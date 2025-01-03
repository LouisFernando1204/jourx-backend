<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diary;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiaryAnalysisController extends Controller
{
   public function weekly(Request $request): JsonResponse
   {
       try {
           $user = $request->user();
           
           if (!$user) {
               return response()->json([
                   'status' => 'error',
                   'message' => 'Unauthorized'
               ], 401);
           }

           $startDate = Carbon::now()->startOfWeek();
           $endDate = Carbon::now()->endOfWeek();

           $data = Diary::where('user_id', $user->id)
               ->whereBetween('created_at', [$startDate, $endDate])
               ->select(
                   DB::raw('DATE(created_at) as date'),
                   DB::raw('AVG(stress_level) as average_stress'),
                   DB::raw('COUNT(*) as diary_count')
               )
               ->groupBy('date')
               ->orderBy('date')
               ->get();

           return response()->json([
               'status' => 'success',
               'data' => [
                   'period' => [
                       'start' => $startDate->format('Y-m-d'),
                       'end' => $endDate->format('Y-m-d')
                   ],
                   'stress_data' => $data->map(function ($item) {
                       return [
                           'date' => Carbon::parse($item->date)->format('Y-m-d'),
                           'day_name' => Carbon::parse($item->date)->format('l'),
                           'average_stress' => round($item->average_stress, 2),
                           'diary_count' => $item->diary_count,
                       ];
                   })
               ]
           ]);
       } catch (\Exception $e) {
           Log::error('Weekly Analysis Error: ' . $e->getMessage());
           return response()->json([
               'status' => 'error',
               'message' => 'Failed to fetch weekly analysis'
           ], 500);
       }
   }

   public function monthly(Request $request): JsonResponse
   {
       try {
           $user = $request->user();
           
           if (!$user) {
               return response()->json([
                   'status' => 'error',
                   'message' => 'Unauthorized'
               ], 401);
           }

           $startDate = Carbon::now()->startOfMonth();
           $endDate = Carbon::now()->endOfMonth();

           $data = Diary::where('user_id', $user->id)
               ->whereBetween('created_at', [$startDate, $endDate])
               ->select(
                   DB::raw('DATE(created_at) as date'),
                   DB::raw('AVG(stress_level) as average_stress'),
                   'emotion',
                   DB::raw('COUNT(*) as count')
               )
               ->groupBy('date', 'emotion')
               ->orderBy('date')
               ->get()
               ->groupBy('date')
               ->map(function ($items, $date) {
                   return [
                       'date' => $date,
                       'average_stress' => round($items->avg('average_stress'), 2),
                       'emotions' => $items->pluck('emotion')->unique(),
                       'diary_count' => $items->sum('count')
                   ];
               });

           return response()->json([
               'status' => 'success',
               'data' => [
                   'period' => [
                       'start' => $startDate->format('Y-m-d'),
                       'end' => $endDate->format('Y-m-d')
                   ],
                   'daily_data' => $data->values()
               ]
           ]);
       } catch (\Exception $e) {
           Log::error('Monthly Analysis Error: ' . $e->getMessage());
           return response()->json([
               'status' => 'error',
               'message' => 'Failed to fetch monthly analysis'
           ], 500);
       }
   }

   public function emotionDistribution(Request $request): JsonResponse
   {
       try {
           $user = $request->user();
           
           if (!$user) {
               return response()->json([
                   'status' => 'error',
                   'message' => 'Unauthorized'
               ], 401);
           }

           $period = $request->input('period', 'month');
           $startDate = Carbon::now();
           
           switch ($period) {
               case 'week':
                   $startDate = $startDate->startOfWeek();
                   break;
               case 'month':
                   $startDate = $startDate->startOfMonth();
                   break;
               case 'year':
                   $startDate = $startDate->startOfYear();
                   break;
           }

           $total = Diary::where('user_id', $user->id)
               ->where('created_at', '>=', $startDate)
               ->count();

           $data = Diary::where('user_id', $user->id)
               ->where('created_at', '>=', $startDate)
               ->select('emotion', DB::raw('COUNT(*) as count'))
               ->groupBy('emotion')
               ->orderByDesc('count')
               ->get()
               ->map(function ($item) use ($total) {
                   return [
                       'emotion' => $item->emotion,
                       'count' => $item->count,
                       'percentage' => $total > 0 ? round(($item->count / $total) * 100, 2) : 0
                   ];
               });

           return response()->json([
               'status' => 'success',
               'data' => [
                   'period' => $period,
                   'emotions' => $data
               ]
           ]);
       } catch (\Exception $e) {
           Log::error('Emotion Distribution Error: ' . $e->getMessage());
           return response()->json([
               'status' => 'error',
               'message' => 'Failed to fetch emotion distribution'
           ], 500);
       }
   }
}