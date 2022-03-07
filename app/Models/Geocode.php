<?php
namespace App\Models;

trait Geocode
{
      /**
       * GetGeoCode Geocoder Trait renamed
       * 
       * @param [type] $geoCode [description]
       * 
       * @return [type]          [description]
       */
    public function getGeoCode($geoCode)
    {
       
        if (is_array($geoCode) && count($geoCode) >0 ) {
            
                $data['lat'] = $geoCode[0]['latitude'];
                $data['lng'] = $geoCode[0]['longitude'];
                $data['geostatus']=true;
        } elseif (is_object($geoCode) && $geoCode->count()>0) {
            
            if (null!==$geoCode->first()) {
                $data['lat'] = $geoCode->first()->getCoordinates()->getLatitude();
                $data['lng'] = $geoCode->first()->getCoordinates()->getLongitude();
            } else {
                return false;
            }
              
            $data['geostatus']=true;
            $data['address'] =  $geoCode->first()
                ->getStreetNumber()." " . $geoCode->first()->getStreetName();
            $data['street'] = $data['address'];
              
            if (! $geoCode->first()->getLocality() 
                && count($geoCode->first()->getadminLevels())>0
            ) {
                foreach ($geoCode->first()->getadminLevels() as $level) {
                    $data['city'] = $level->getName();
                }
            } else {
                $data['city'] =  $geoCode->first()->getLocality();
            }
                
            $data['zip'] = $geoCode->first()->getPostalCode();

            if (count($geoCode->first()->getadminLevels())>0) {
                   
                $data['state'] = $geoCode->first()
                    ->getadminLevels()
                    ->first()
                    ->getCode();
            } else {
                $data['state']=null;
             
            }
            if ($geoCode->first()->getCountry()) {
                $data['country'] = $geoCode->first()
                    ->getCountry()
                    ->getCode();     

            } else {
                $data['country'] =null;
            }

            $data['fulladdress'] = trim(
                $data['address'] 
                    .' ' . $data['city']
                    .' ' . $data['state'] 
                    .' ' . $data['zip']
                    .' ' . $data['country']
            );
            $data['position']= $this->setLocationAttribute($data);
        } else {
            $data['lat'] = null;
            $data['lng'] = null;
            $data['geostatus']=false;
        }
          
          return $data;
    }
    public function scopeGetWithinMBR($query, $box)
    {

        return $this->where('lat', '<', $box['maxLat'])
            ->where('lat', '>', $box['minLat'])
            ->where('lng', '<', $box['maxLng'])
            ->where('lng', '>', $box['minLng']);
    }
    /**
     * ScopeNearby [description]
     * 
     * @param [type]  $query    [description]
     * @param [type]  $location [description]
     * @param integer $radius   [description]
     * @param [type]  $limit    [description]
     * 
     * @return [type]            [description]
     */
    public function scopeNearby($query, $location, $radius = 100, $limit = null)
    {
        
        $geocode = Geolocation::fromDegrees($location->lat, $location->lng);
        
        $bounding = $geocode->boundingCoordinates($radius, 'mi');
        
        
        return $query
            ->select()//pick the columns you want here.
            ->selectRaw("{$this->_haversine($location)} AS distance")
            
            ->whereRaw("{$this->_haversine($location)} < $radius ")
            ->orderBy('distance', 'ASC')
            ->when(
                $limit, function ($q) use ($limit) {
                   $q->limit($limit);
                }
            );
    }

    public function scopeCountNearby($query, $location,  $radius = 100, $limit = null)
    {
        

        return  $query
            ->selectRaw("count('id')")//pick the columns you want here.
            
            ->whereRaw("{$this->_haversine($location)} < $radius ")


            ->when(
                $limit, function ($q) use ($limit) {
                
                    $q->limit($limit);
                }
            );
    }
    /*
     * ScopeNewNearby [description]
     * 
     * @param [type]  $query    [description]
     * @param [type]  $location [description]
     * @param integer $radius   [description]
     * @param [type]  $limit    [description]
     * 
     * @return [type]            [description]
     */
    public function scopeNewNearby($query, $location, $radius = 100, $limit = null)
    {
    
        
        $geocode = Geolocation::fromDegrees($location->lat, $location->lng);
    
        $bounding = $geocode->boundingCoordinates($radius, 'mi');
       
        $sub = $this->selectSub('id', 'lat', 'lng')
            ->whereBetween('lat', [$bounding['min']->degLat,$bounding['max']->degLat])
            ->whereBetween('lng', [$bounding['min']->degLon,$bounding['max']->degLon]);

        return $query
            ->select()//pick the columns you want here.
            ->selectRaw("st_distance_sphere($this->table.position, $location.position) * 0.00062137119 AS distance")
            ->mergeBindings($sub->getQuery())
            ->whereRaw("st_distance_sphere($this->table.position, $location.position) * 0.00062137119 < $radius ")

            ->orderBy('distance', 'ASC')->when(
                $limit, function ($q) use ($limit) {
                    $query = $q->limit($limit);
                }
            );
    }
    /**
     * LocationsNearbyBranches [description]
     * 
     * @param Company $company [description]
     * @param integer $radius  [description]
     * @param [type]  $limit   [description]
     * 
     * @return [type]           [description]
     */
    public function locationsNearbyBranches(Company $company, $radius = 25, $limit = null)
    {
        //add pagination

        // can refactor this with
        $query ="select 
                locs.id,
                locs.businessname,
                locs.street as locstreet, 
                locs.city as loccity, 
                locs.state as locstate,
                locs.zip as loczip,
                branch.branchname,
                branch.id as branch_id,
                branch.city,
                branch.state,
                branch.phone as branch_phone,
                branchfilter.branchdistance,
                people.id as pid,
                people.depth as depth,
                concat_ws(' ',people.firstname,people.lastname) as repname,
                peepsfilter.peepsdistance,
                people.phone
            from locations locs, 
                branches branch,
                persons people,
                (select 
                        blocs.id as blocid,
                        branches.id as branchid,
                        branches.city ,
                        3956 * acos(cos(radians(blocs.lat)) 
                        * cos(radians(branches.lat)) 
                        * cos(radians(branches.lng) 
                        - radians(blocs.lng)) 
                        + sin(radians(blocs.lat)) 
                        * sin(radians(branches.lat))) as branchdistance

                    from locations blocs
                    left join branches on (
                        3956 * acos(cos(radians(blocs.lat)) 
                        * cos(radians(branches.lat)) 
                        * cos(radians(branches.lng) 
                        - radians(blocs.lng)) 
                        + sin(radians(blocs.lat)) 
                        * sin(radians(branches.lat))) 
                        < branches.radius
                        ) 

                    where blocs.company_id = " . $company->id . "
                    order by blocid,branchdistance) branchfilter,

                (select 
                        plocs.id as plocid,
                        peeps.id as peepid,
                        3956 * acos(cos(radians(plocs.lat)) 
                        * cos(radians(peeps.lat)) 
                        * cos(radians(peeps.lng) 
                        - radians(plocs.lng)) 
                        + sin(radians(plocs.lat)) 
                        * sin(radians(peeps.lat))) as peepsdistance 
                    from locations plocs
                    left join 
                    (select persons.* from persons,role_user,roles
                        where persons.user_id = role_user.user_id 
                        and role_user.role_id = roles.id 
                        and roles.name = 'Sales') peeps
                    on (
                        3956 * acos(cos(radians(plocs.lat)) 
                        * cos(radians(peeps.lat)) 
                        * cos(radians(peeps.lng) 
                        - radians(plocs.lng)) 
                        + sin(radians(plocs.lat)) 
                        * sin(radians(peeps.lat))) 
                        < 100
                    ) 
                    where plocs.company_id = ". $company->id ."
                    order by plocid,peepsdistance) peepsfilter
            where peepsfilter.plocid = branchfilter.blocid
            and locs.id = branchfilter.blocid
            and people.id = peepsfilter.peepid
            and branch.id = branchfilter.branchid
            order by locs.id";

          return \DB::select($query);
    }
    /**
     * ScopeAssociateCompanyLocationsBranches [description]
     * 
     * @param Company $company [description]
     * @param integer $radius  [description]
     * 
     * @return [type]           [description]
     */
    public function scopeAssociateCompanyLocationsBranches(Company $company, $radius = 25)
    {
        
        $query = "select distinct branches.id as branch_id, addresses.id as address_id 
                    from branches,addresses 
                    left join address_branch
                    on addresses.id = address_branch.address_id
                    where ST_Distance_Sphere(branches.position,addresses.position) < '". $distance."'
                    and addresses.company_id = '" . $company->id ."'
                    and address_branch.address_id is null
                    ORDER BY branches.id asc";
    }
    /**
     * _Haversine [description]
     * 
     * @param [type] $location [description]
     * 
     * @return [type]           [description]
     */
    private function _haversine($location)
    {
        
        return "(3956 * acos(cos(radians($location->lat)) 
                     * cos(radians($this->table.lat)) 
                     * cos(radians($this->table.lng) 
                     - radians($location->lng)) 
                     + sin(radians($location->lat)) 
                     * sin(radians($this->table.lat))))";
    }
    
    /**
     * DistanceBetween [description]
     * 
     * @param [type] $lat1 [description]
     * @param [type] $lon1 [description]
     * @param [type] $lat2 [description]
     * @param [type] $lon2 [description]
     * @param [type] $unit [description]
     * 
     * @return [type]       [description]
     */
    public function distanceBetween($lat1, $lon1, $lat2, $lon2, $unit = null)
    {
        
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
    /**
     * GetMyPosition [description]
     * 
     * @return [type] [description]
     */
    public function getMyPosition()
    {
        $location = new Location;
            //$limited=$this->limit;
            //we need to test to see if geo is filled
        if ($geo = session()->get('geo') && isset($geo['lat'])) {
                $location->lat = $geo['lat'];
                $location->lng = $geo['lng'];
        } elseif ($position = auth()->user()->position()) {
            $position = explode(",", auth()->user()->position());
            $location->lat =  $position[0];
            $location->lng =  $position[1];
            $location->address = auth()->user()->person->fulladdress();
        } else {
            //default to Tacoma
            $location->lat =  '47.25';
            $location->lng =  '-122.44';
            $location->address = 'A St, Tacoma, WA';
        }
        return $location;
    }
    /**
     * DistanceFromMe [description]
     * 
     * @param Collection $collection [description]
     * 
     * @return [type]             [description]
     */
    public function distanceFromMe($collection)
    {
        
        $myPosition = $this->getMyPosition();
        return $collection->map(
            function ($item) use ($myPosition) {
                $item->distance = $this->distanceBetween($myPosition->lat, $myPosition->lng, $item->lat, $item->lng);
                return $item;
            }
        );
    }
    /**
     * GetBoundingBox [description]
     * 
     * @param [type] $collection [description]
     * 
     * @return [type]             [description]
     */
    public function getBoundingBox($collection)
    {
        
        $data['maxLat'] = $collection->max('lat') + 0.05;
        $data['minLat'] = $collection->min('lat') - 0.05;
        $data['maxLng'] = $collection->max('lng') - 0.05;
        $data['minLng'] = $collection->min('lng') + 0.05;
       
        return $data;
    }

    
    /**
     * ScopeWithinMBR [description]
     * 
     * @param [type] $query [description]
     * @param [type] $box   [description]
     * 
     * @return [type]        [description]
     */
    public function scopeWithinMBR($query,$box)
    {
        
        return $query->whereRaw("MBRContains( GeomFromText('LINESTRING(".$box['maxLng']." " .$box['minLat'] . ", ". $box['minLng']." " . $box['maxLat'].")' ), position)");
    }
    /**
     * GeoCodeAddress [description]
     * 
     * @param string $address [description]
     * 
     * @return Object         [description]
     */
    public function geoCodeAddress(string $address)
    {

        $geoCode = app('geocoder')->geocode($address)->get();
        return $this->getGeoCode($geoCode);
    }

    protected $geofields = ['position'];

    /**
     * SetLocationAttribute [description]
     * 
     * @param array $data [description]
     * 
     * @return [<description>]
     */
    public function setLocationAttribute($data)
    {
        $LngLat = $data['lng']." ".$data['lat'];
        return \DB::raw("ST_GeomFromText('POINT($LngLat)',4326)");
    }
    /**
     * GetLocationAttribute [description]
     * 
     * @param [type] $value [description]
     * 
     * @return [type]        [description]
     */
    public function getLocationAttribute($value)
    {
        $loc =  substr($value, 6);
        $loc = preg_replace('/[ ,]+/', ',', $loc, 1);
        return substr($loc, 0, -1);
    }
    /**
     * [setGeoSession description]
     * 
     * @param Model  $address  [description]
     * @param [type] $distance [description]
     *
     * @return session [<description>]
     */
    public function setGeoAddressSession(Address $address, $distance)
    {
        if ($address->lat && $address->lng ) {
            session(
                [
                'geo'=>$address->toArray(),
                'geo.address'=>$address->fulladdress(),
                'geo.distance'=>$distance,
                
                ]
            );
        }
    }

    /**
     * [setGeoBranchSession description]
     * 
     * @param Branch $branch   [description]
     * @param [type] $distance [description]\
     *
     * @return session [<description>]
     */
    public function setGeoBranchSession(Branch $branch, $distance)
    {
        if ($branch->lat && $branch->lng ) {
            session(
                [
                'geo'=>$branch->toArray(),
                'geo.address'=>$branch->fulladdress(),
                'geo.distance'=>$distance,
                'geo.branch' =>$branch->id,
                
                ]
            );
        }
    }
    /**
     * ScopeDistance [description]
     * 
     * @param [type] $query    [description]
     * @param [type] $position [description]
     * @param [type] $dist     [description]
     * 
     * @return [type]           [description]
     */
    public function scopeDistance($query, $position, $dist=null)
    {
        
        return $query->whereRaw('ST_Distance_Sphere(position, POINT(' . $position->lng ."," .$position->lat . ')) < ' . $dist);
        

    }
    /**
     * ScopeWithDistance [description]
     * 
     * @param [type] $query    [description]
     * @param [type] $position [description]
     * 
     * @return [type]           [description]
     */
    public function scopeWithDistance($query, $location)
    {
        return $query->selectRaw("*, (ST_DISTANCE_SPHERE(POINT($location->lng, $location->lat), POINT(lng, lat))/1609.344) as distance");
        //ST_DISTANCE_SPHERE(POINT($position->lng, $position->lat), POINT(lng, lat)) 
    }

    /**
     * ScopeCloseTo Return addresses within radius
     * 
     * @param [type]  $query    [description]
     * @param Object  $location [description]
     * @param integer $radius   [description]
     * 
     * @return Builder           Query
     */
    public function scopeCloseTo($query, $location, $radius = 25)
    {
        return $query->whereRaw(
            "ST_Distance_Sphere(
                    point(lng, lat),
                    point(?, ?)
                ) * .000621371192 < ?", 
            [
                $location->lng,
                $location->lat,
                $radius,
            ]
        );
    }
}
