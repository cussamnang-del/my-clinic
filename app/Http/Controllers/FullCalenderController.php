<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class FullCalenderController extends Controller
{
    public function calendar3(Request $request)
    {
        if ($request->ajax()) {
            $data = Event::whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get(['id', 'title', 'start', 'end', 'color', 'allDay']);

            return response()->json($data);
        }

        return view('full-calender');
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'type' => 'required|in:add,update,delete',
                'title' => 'required_if:type,add,update|string|max:255',
                'start' => 'required_if:type,add,update|date',
                'end' => 'required_if:type,add,update|date',
                'color' => 'nullable|string|max:20',
                'allDay' => 'nullable|boolean',
                'id' => 'required_if:type,update,delete|integer|exists:events,id',
            ]);

            if ($request->type == 'add') {
                $event = Event::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'color' => $request->color,
                    'allDay' => $request->boolean('allDay'),
                ]);

                return response()->json($event);
            }

            if ($request->type == 'update') {
                $event = Event::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'color' => $request->color,
                    'allDay' => $request->boolean('allDay'),
                ]);

                return response()->json($event);
            }

            if ($request->type == 'delete') {
                $event = Event::find($request->id)->delete();

                return response()->json($event);
            }
        }
    }
}
