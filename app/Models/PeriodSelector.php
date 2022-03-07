<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;
use Illuminate\Http\Request;

trait PeriodSelector
{
    public $period = [];
    public $default = 'thisWeek';
    /**
     * [setPeriod description]
     * 
     * @param [type] $period [description]
     *
     * @return array this period
     */
    public function setPeriod(Request $request)
    {
        
        if (! request()->has('period')) {
            $this->period = $this->_default();
        } elseif (method_exists($this, request('period'))) {
            $period = request('period');
            $this->period = $this->$period();
        } else {
            $this->period = $this->_default();
        }
        session()->put('period', $this->period);
       
        return redirect()->back();
    }

    public function livewirePeriod($period = null, $session=true)
    {
        
        if (! $period) {
            $this->period = $this->_default();
            
        } elseif (method_exists($this, $period)) {
            $this->period = $this->$period();
            
        } elseif ($period === 'All') {
            $this->period = $this->allDates();
            
        } else {
            $this->period = $this->_default();
            
        }
        session()->put('period', $this->period);
    }
    /**
     * [getPeriod description]
     * 
     * @param [type] $period [description]
     * 
     * @return [type]         [description]
     */
    public function getPeriod($period=null)
    {
        
        if (! $period && session('period')) {
                
                $this->period = session('period');
            
        } elseif ($period && method_exists($this, $period)) {
                $this->period = $this->$period(); 
            
        } else {
                $this->period = $this->thisWeek(); 
                
        }
        session()->put('period', $this->period);
      
        return $this->period;
    }

    /**
     * [default description]
     * 
     * @return [type] [description]
     */
    private function _default()
    {
        return $this->thisWeek();
    }


    /**
     * Future
     * returns begining and end of today
     * 
     * @return array of from & to  Carbon instance
     */
    private function future()
    {
        $data['from'] = Carbon::today()->startOfDay();
        $data['to'] = Carbon::now()->addYear(5)->endOfDay();
        $data['period'] = 'future';
        return $data;

    }
    /**
     * Today
     * returns begining and end of today
     * 
     * @return array of from & to  Carbon instance
     */
    private function today()
    {
        $data['from'] = Carbon::today()->startOfDay();
        $data['to'] = Carbon::today()->endOfDay();
        $data['period'] = 'today';
        return $data;

    }
    /**
     * Yesterday
     * returns begining and end of yeasterday
     * 
     * @return array of from & to  Carbon instance
     */
    private function yesterday()
    {
        $data['from'] = Carbon::yesterday()->startOfDay();
        $data['to'] = Carbon::yesterday()->endOfDay();
        $data['period'] = 'yesterday';
        return $data;
    }
    
    /**
     * LastDays returns last x Days
     * 
     * @param integer $number number of days
     * 
     * @return array of from & to  Carbon instance
     */
    private function lastDays($number)
    {
        $data['from'] = Carbon::now()->subDays($number)->startOfDay();
        $data['to'] = Carbon::now()->endOfDay();
        $data['period'] = 'last ' . $number . ' days';
        return $data;

    }
    /**
     * This Week - Returns beging and end of current week
     * 
     * @return array of from & to  Carbon instance
     */
    private function thisWeek()
    {
        
        $data['from'] = Carbon::now()->startOfWeek()->startOfDay();
        $data['to'] = Carbon::now()->endOfWeek()->endOfDay();
        $data['period'] = 'thisWeek';
        return $data;
    }
    /**
     * [thisWeekToDate returns beginning and current time
     * of current week
     * 
     * @return array of from & to  Carbon instance*
     */
    private function thisWeekToDate()
    {
    
        $data['from'] = Carbon::now()->startOfWeek()->startOfDay();
        $data['to'] = Carbon::now()->createMidnightDate()->endOfDay();
        $data['period'] = 'thisWeekToDate';

        return $data;

    }

    /**
     * Last Week returns beginning and end of last week
     * 
     * @return array of from & to  Carbon instance
     */
    private function lastWeek()
    {
        
        $data['from'] = Carbon::now()->subWeek(1)->startOfWeek()->startOfDay();
        $data['to'] = Carbon::now()->subWeek(1)->endOfWeek()->endOfDay();
        $data['period'] = 'lastWeek';
        return $data;
    }
    /**
     * This Month returns beginning and end of current month
     * 
     * @return array of from & to  Carbon instance
     */
    private function thisMonth()
    {
        $data['from'] = Carbon::now()->startOfMonth()->startOfDay();
        $data['to'] = Carbon::now()->endOfMonth()->endOfDay();
        $data['period'] = 'thisMonth';
        return $data;

    }
    /**
     * This MonthToDate returns from beginning of current month
     * to current date time.
     * 
     * @return array of from & to  Carbon instance
     */
    private function thisMonthToDate()
    {
        $data['from'] = Carbon::now()->startOfMonth()->startOfDay();
        $data['to'] = Carbon::now()->endOfDay();
        $data['period'] = 'thisMonthToDate';
        return $data;

    }
    /**
     * LastMonth returns beginning and end of last month
     * 
     * @return array of from & to  Carbon instance
     */
    private function lastMonth()
    {
        $data['from'] = Carbon::now()->subMonth(1)->startOfMonth()->startOfDay();
        $data['to'] = Carbon::now()->subMonth(1)->endOfMonth()->endOfDay();;
        $data['period'] = 'lastMonth';
        return $data;

    }
    
    
    /**
     * ThisQuarter returns beginning and end
     * dates of current quarter
     * 
     * @return array of from & to  Carbon instance
     */
    private function thisQuarter()
    {
    
        $data['from'] = Carbon::now()->firstOfQuarter()->startOfDay();;
        $data['to'] = Carbon::now()->lastOfQuarter()->endOfDay();;
        $data['period'] = 'thisQuarter';
        return $data;
    }
    /**
     * ThisQuarterToDate returns beginging date
     * of current quarter to current date
     * 
     * @return array of from & to  Carbon instance
     */
    private function thisQuarterToDate()
    {
        
        
        $data['from'] = Carbon::now()->firstOfQuarter()->startOfDay();;
        $data['to'] = Carbon::now()->endOfDay();
        $data['period'] = 'thisQuarterToDate';
        return $data;
    }
    /**
     * LastQuarter returns begining and ending dates
     * of last Quarter
     * 
     * @return [type] [description]
     */
    private function lastQuarter()
    {
        $data['from'] =  Carbon::now()->subMonths(3)->firstOfQuarter()->startOfDay();
        $data['to'] =  Carbon::now()->subMonths(3)->lastOfQuarter()->endOfDay();;
        $data['period'] = 'lastQuarter';
        return $data;
    }
    
    /**
     * ThisQuarterToDate returns beginging date
     * of current quarter to current date
     * 
     * @return array of from & to  Carbon instance
     */
    private function lastSixMonths()
    {
        
        
        $data['from'] = Carbon::now()->subMonths(6)->startOfDay();;
        $data['to'] = Carbon::now()->endOfDay();;
        
        $data['period'] = 'lastSixMonths';
        return $data;
    }
    /**
     * ThisQuarterToDate returns beginging date
     * of current quarter to current date
     * 
     * @return array of from & to  Carbon instance
     */
    private function lastThreeMonths()
    {
        
        
        $data['from'] = Carbon::now()->subMonths(3)->startOfDay();;
        $data['to'] = Carbon::now()->endOfDay();;
        
        $data['period'] = 'lastThreeMonths';
        return $data;
    }

    private function allDates()
    {
        $data['from'] = Carbon::now()->subYear(6)->startOfYear(); 
        $data['to'] = Carbon::now()->addYear(6)->endOfYear();
        
        $data['period'] = 'allDates';
        return $data;
    }

    private function tomorrow()
    {
        $data['from'] = Carbon::tomorrow(); 
        $data['to'] = Carbon::tomorrow()->endOfDay();
        
        $data['period'] = 'tomorrow';
        return $data;
    }
    private function nextWeek()
    {
        $data['from'] = Carbon::now()->addWeek(1)->startOfWeek()->startOfDay();
        $data['to'] = Carbon::now()->addWeek(1)->endOfWeek()->endOfDay();
        $data['period'] = 'nexttWeek';
        return $data;
    }
    private function nextMonth()
    {
        $data['from'] = Carbon::now()->addMonth(1)->startOfMonth()->startOfDay();
        $data['from'] = Carbon::now()->addMonth(1)->endOfMonth()->endOfDay();
        $data['period'] = 'nextMonth';
        return $data;
    }
    private function nextQuarter()
    {
        $data['from'] = Carbon::now()->addMonth(3)->startOfQuarter()->startOfDay();
        $data['from'] = Carbon::now()->addMonth(3)->endOfQuarter()->endOfDay();
        $data['period'] = 'nextMonth';
        return $data;
    }

}
