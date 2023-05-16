<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();
        $messages = MessageResource::collection($messages)->resolve();
        return Inertia('Message/Index', compact('messages'));
    }

    public function store(StoreRequest $request)
    {
        $date = $request->validated();
        $message = Message::create($date);

        event(new StoreMessageEvent($message));

        return MessageResource::make($message)->resolve();
    }
}
