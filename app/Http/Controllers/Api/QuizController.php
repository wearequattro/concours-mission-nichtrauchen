<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuizController extends Controller {

    public function quizMakerWebhook(Request $request) {
        $json = $request->get('json');
        \Log::info("Received quiz maker webhook: " . $json);
        $json = json_decode($json);

        return response();
    }

}
