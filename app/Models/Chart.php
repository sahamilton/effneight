<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    /**
     * [getTeamActivityChart description]
     * 
     * @param array $data [description]
     * 
     * @return [type]       [description]
     */
    public function getTeamActivityChart(array $data)
    {
     
        $chart= array();
        foreach ($data['team'] as $team) {

            if (isset($data['data'][$team->id]['activities'])) {
                $chart[$team->postName()]=$data['data'][$team->id]['activities'];
            } else {
                $chart[$team->postName()]=0;
            }

        }
        return $this->_getChartData($chart);
    }
    /**
     * [getTeamActivityByTypeChart description]
     * 
     * @param array $data [description]
     * 
     * @return [type]       [description]
     */
    public function getTeamActivityByTypeChart(array $data)
    {
    
        $full = ActivityType::all()->pluck('activity', 'color')->toArray();
       
        // Initialize
        
        $chart['labels']= "'" . implode("','", $data['teamdata']->keys()->toArray()). "'";
        foreach ($full as $color=>$activity) {
            $chart['data'][$activity]['color']=$color;
            $chart['data'][$activity]['labels']=$chart['labels'];
            $type = str_replace(" ", "_", strtolower($activity));
            $chart['data'][$activity]['data'] =  implode(",", $data['teamdata']->pluck($type)->toArray());
        }
       
        return $chart;
        
    }
    /**
     * [getTeamActivityByTypeChart description]
     * 
     * @param array $data [description]
     * 
     * @return [type]       [description]
     */
    public function getBranchesActivityByTypeChart(array $data)
    {

        $full = ActivityType::all()->pluck('activity', 'color')->toArray();
        
        
        // Initialize
        $labels = $data['branches']->map(
            function ($branch) {
                return ['id'=>$branch->id,'name'=>$branch->branchname];
            }
        );
        

        $chart['labels'] = "'" .  implode("','", $labels->pluck('name')->toArray())."'";
        
        foreach ($full as $color=>$activity) {
            $chart['data'][$activity]['color']=$color;
            $chart['data'][$activity]['labels']=$chart['labels'];
            $type = str_replace(" ", "_", strtolower($activity));
            $chart['data'][$activity]['data'] = implode(",", $data['branches']->pluck($type)->toArray());
        }
        return $chart;
        
    }
    private function _getActivityTypeColors()
    {
        $colors = ActivityType::select('activity','color')->get();
        foreach ($colors as $color) {
            $data[str_replace(" ", "",strtolower($color->activity))] = $color->color;
        }
        return $data;
    }
    /**
     * Transpose array
     * 
     * @param array $array [description]
     * 
     * @return array $out [description]
     */
    private function _transpose(Array $array)
    {

        $out = array();
        foreach ($array as $key => $subarr) {
            foreach ($subarr as $subkey => $subvalue) {
                $out[$subkey][$key] = $subvalue;
            }
        }
        return $out;

    }
   
    public function getBranchChart(array $data, $field)
    {
        
       
        $chart['keys'] = "'" . implode("','", $data['branches']->pluck('branchname')->toArray())."'";
        $chart['data'] = implode(",", $data['branches']->pluck($field, 'branchname')->toArray());

        return $chart;
    }

    /**
     * [getTeamTop25Chart description]
     * 
     * @param array $data [description]
     * 
     * @return [type]       [description]
     */
    public function getTeamChart(array $data, $field)
    {
        
        
        $chart['data'] =  implode(",", $data['teamdata']->pluck($field)->toArray()); 
        $chart['keys'] = "'" . implode("','", $data['teamdata']->keys()->toArray())."'";
        
        return $chart;
    }
    
   
   

    /**
     * [_getChartData description]
     * 
     * @param [type] $chart [description]
     * 
     * @return [type]        [description]
     */
    private function _getChartData($chart)
    {
        
        $data['chart']['keys'] = "'" . implode("','", array_keys($chart))."'";
        $data['chart']['data'] = implode(",", $chart);
        return $data;
    }

    /**
     * [getTeamActivityByTypeChart description]
     * 
     * @param array $data [description]
     * 
     * @return [type]       [description]
    */
    public function getBranchActivityByDateTypeChart(Object $data)
    {
        $labels = $data->pluck('day')->unique()->toArray();
        sort($labels);
        $labelstring = implode("','", $labels);
            
        $raw = $data->groupBy('activitytype_id');
        $activitytypes = ActivityType::all();
        $chart= array();
        foreach ($raw as $key=>$el) {
            $activity = $activitytypes->where('id', '=', $key)->first();
            $chart[$activity->activity]=[];
            foreach ($labels as $label) {
                if ($e = $el->where('day', '=', $label)->first()) {
                    $res[$activity->activity]['data'][] = $e->activities;
                } else {
                    $res[$activity->activity]['data'][] = 0;
                }
                
            }
            $chart[$activity->activity]['color'] = "#".$activity->color;
            $chart[$activity->activity]['data'] = implode(",", $res[$activity->activity]['data']);
            $chart[$activity->activity]['labels'] = $labelstring;
        }

        return $chart;

    }

    public function createColors($num)
    {
        $colors=[];
        $int = 0;
        // value must be between [0, 510]
        for ($int; $int<$num; $int++) {
            $i = 1/$num + ($int*(1/$num));
            $value = min(max(0, $i), 1) * 508;
            if ($value < 255) {
                $greenValue = 255;
                $redValue = sqrt($value) * 16;
                $redValue = round($redValue);
            } else {
                $redValue = 255;
                $value = $value - 255;
                $greenValue = 256 - ($value * $value / 255);
                $greenValue = round($greenValue);
            }
            
            $colors[$int]= "#" .  $this->_decToHex($redValue). $this->_decToHex($greenValue) . "00";
        }
        return $colors;
    }

    /**
     * [_decToHex description]
     * 
     * @param [type] $value [description]
     * 
     * @return [type]        [description]
     */
    private function _decToHex($value)
    {
        if (strlen(dechex($value))<2) {
            return "0".dechex($value);
        } else {
            return dechex($value);
        }
    }
}
