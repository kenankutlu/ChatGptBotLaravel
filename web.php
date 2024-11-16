<?php

use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/chat', [HomeController::class, 'chat'])->name('chat');

Route::post('/ask-chatbot', [ChatBotController::class, 'ask'])->name('ask-chatbot');

