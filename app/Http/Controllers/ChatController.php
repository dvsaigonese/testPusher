<?php

namespace App\Http\Controllers;

use App\Events\GreetingSent;
use App\Events\MessageSent;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showChat()
    {
        return view("chat.show");
    }

    public function messageReceived(Request $request)
    {
        $rule = [
            "message" => "required",
        ];
        $request->validate($rule);

        broadcast(new MessageSent($request->user(), $request->message));
        return response()->json("Message Broadcast");
    }
    public function greetReceived(Request $request, User $user)
    {
        //tham số user thứ hai đại diện cho người nhận còn lại
        broadcast(
            new GreetingSent($user, "{$request->user()->name} greeted you")
        );
        broadcast(
            new GreetingSent($request->user(), "You greeted {$user->name}")
        );
        return "Greeting {$user->name} from {$request->user()->name}";
    }
}