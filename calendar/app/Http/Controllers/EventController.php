<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventGetRequest;
use App\Http\Requests\ModEventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * @param EventCreateRequest $request
     * @return string
     */
    public function createEvent(EventCreateRequest $request) {

        try {
            $request->validated();

            $event = [
                'name' => $request->input('name'),
                'note' => $request->input('note'),
                'priority' => $request->input('priority'),
                'begin' => $request->input('begin'),
                'end' => $request->input('end'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $event = DB::table('events')->insertGetId($event);

            if($event) {
                return response(json_encode([
                    'id' => $event,
                    'status' => 200
                ]));
            } else
                return abort(404);

        } catch (\PDOException $e) {
            return $e->getMessage();
        }
        catch (\Exception $e) {
            echo $e->getMessage();
            return $e->getTraceAsString();
        }

    }

    public function getEvent() {

    }

    /**
     * @param $get_by
     * @param EventGetRequest $request
     * @return \Illuminate\Support\Collection|string|void
     */
    public function getEventBy($get_by, EventGetRequest $request) {

        try {
            if(array_search($get_by, ['id', 'name','note', 'priority', 'begin', 'end', 'created_at', 'updated_at'])) {

                $request->validated();
                $searchStr = $request->input($get_by);

                $result = DB::table('events')->where($get_by, '=', $searchStr)->get();

                if ($result[0])
                    return $result;
            }
            return response('Nessuna risorsa trovata', 404);

        } catch (\Exception $e) {
            echo $e->getMessage();
            return $e->getTraceAsString();
        }

    }

    /**
     * @param $year
     * @return array|void
     */
    public function getYear($year) {

        $events = DB::table('events')->get();
        $result = [];

        foreach ($events as $event) {
            if ($year == date('Y', strtotime($event->begin)))
                $result[] = $event;
        }

        if ($result[0]) {
            return $result;
        }
        else {
            echo $year;
            return response('Nessuna risorsa trovata', 404);
        }
    }

    /**
     * @param $year
     * @param $month
     * @return array|void
     */
    public function getMonth($year, $month) {

        $events = DB::table('events')->get();
        $result = [];

        foreach ($events as $event) {
            if (implode('-', [$year, $month]) == date('Y-m', strtotime($event->begin)))
                $result[] = $event;
        }

        if ($result[0])
            return $result;
        else
            return response('Nessuna risorsa trovata', 404);
    }

    /**
     * @param $year
     * @param $week
     * @return array|void
     */
    public function getWeek($year, $week) {

        $events = DB::table('events')->get();
        $result = [];

        foreach ($events as $event) {
            if (implode('-', [$year, $week]) == date('Y-W', strtotime($event->begin)))
                $result[] = $event;
        }

        if ($result[0])
            return $result;
        else
            return response('Nessuna risorsa trovata', 404);
    }

    /**
     * @param $year
     * @param $month
     * @param $day
     * @return array|void
     */
    public function getDay($year, $month, $day) {

        $events = DB::table('events')->get();
        $result = [];

        foreach ($events as $event) {
            if (implode('-', [$year, $month, $day]) == date('Y-m-d', strtotime($event->begin)))
                $result[] = $event;
        }

        if ($result[0])
            return $result;
        else
            return response('Nessuna risorsa trovata', 404);
    }

    /**
     * @param $id
     * @param ModEventRequest $request
     * @return int|string|void
     */
    function modEvent($id, ModEventRequest $request) {

        try {
            $request->validated();

            $modified = DB::table('events')->where('id', '=', $id)
                ->update(array_diff([
                    'name' => $request->input('name'),
                    'note' => $request->input('note'),
                    'priority' => $request->input('priority'),
                    'begin' => $request->input('begin'),
                    'end' => $request->input('end')
                ], ["null", ""]));

            if ($modified)
                return ;
            else
                return abort(404);

        } catch (\Exception $e) {
            echo $e->getMessage();
            return $e->getTraceAsString();
        }
    }
    /**
     * @param $id
     * @return int|string|void
     */
    public function  deleteEvent ($id) {

        try {
            $deleted = DB::table('events')->delete($id);

            if ($deleted)
                return $deleted;
            else
                return abort(404);

        } catch (\Exception $e) {
            echo $e->getMessage();
            return $e->getTraceAsString();
        }

    }
    /**
     * @param $year
     * @param null $month
     * @param null $day
     * @return array|string
     */
    public function  deleteBy($year, $month = null, $day = null) {

        try {
            $toDelete = [];

            if($day)
                $toDelete = $this->getDay($year, $month, $day);
            elseif($month)
                $toDelete = $this->getMonth($year, $month);
            elseif($year)
                $toDelete = $this->getYear($year);



            foreach ($toDelete as $event)
                $this->deleteEvent($event->id);

            if($toDelete)
                return $toDelete;
            else
                return abort(404, "Those parameters don't match any instance");

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

}
