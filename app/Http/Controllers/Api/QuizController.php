<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\QuizAssignment;
use App\QuizInLanguage;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Http\Request;

class QuizController extends Controller {

    public function quizMakerWebhook(Request $request) {
        $json = $request->get('json');
        \Log::info("Received quiz maker webhook");

        $filename = 'quiz-maker-hooks/' . date('Y-m-d_H-i-s') . '.txt';
        \Storage::put($filename, $json);
        Bugsnag::leaveBreadcrumb("quiz maker webhook saved as: $filename");

        $json = json_decode($json);

        $qID = $json->quiz->id;
        $qIL = QuizInLanguage::where('quiz_maker_id', $qID)->first();

        if (!$qIL) {
            \Log::error("Got quiz maker webhook but cannot find its id in our database", ['quiz-maker-id' => $qID]);
            return response()->json();
        }

        foreach ($json->responses as $res) {
            $code = $res->pass;
            /** @var QuizAssignment $assignment */
            $assignment = $qIL->assignments()->where('code', $code)->first();
            if (!$assignment) {
                \Log::error("Given code cannot be matched to an assignment", ['code' => $code]);
                continue;
            }
            if ($assignment->response()->exists()) {
                \Log::warning("Given code is already in database.. updating it", ['code' => $code]);
            }
            $assignment->response()->updateOrCreate([
                'quizmaker_response_id' => $res->id,
            ], [
                'quizmaker_response_id' => $res->id,
                'score' => $res->score,
            ]);
        }


        return response()->json();
    }

}
