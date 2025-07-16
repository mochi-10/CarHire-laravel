<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'submit']);
    }

    
    public function submit(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = new Message();
        $message->user_id = Auth::check() ? Auth::id() : null;
        $message->email = Auth::check() ? Auth::user()->email : $request->email;
        $message->message = $request->message;
        $message->save();

        if (Auth::check() && Auth::user()->role === 'Admin') {
            alert()->success('Success', 'Message sent successfully.');
            return redirect()->route('contact.messages');
        } else {
            alert()->success('Success', 'Message sent successfully.');
            return redirect()->back();
        }
    }

    public function messages()
    {
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $messages = Message::paginate(5);
        $total_messages = Message::count();
        
        return view('messages', compact('messages', 'total_messages'));
    }

    public function deleteMessage($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $message = Message::findOrFail($id);
        $message->delete();

        alert()->success('Success', 'Message deleted successfully.');
        return redirect()->route('contact.messages');
    }

    public function replyMessage(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        // $request->validate([
        //     'reply' => 'required|string',
        // ]);

        $message = Message::findOrFail($id);
        Mail::raw($request->reply, function ($mail) use ($message) {
            $mail->to($message->email)
                ->subject('Reply to your message');
});

        alert()->success('Success', 'Reply sent successfully.');
        return redirect()->route('contact.messages');
    }
}
