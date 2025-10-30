<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ContactRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    protected $contactRepo;

    public function __construct(ContactRepositoryInterface $contactRepo)
    {
        $this->contactRepo = $contactRepo;
    }

    // Danh sách các câu hỏi client
    public function index()
    {
        // Chỉ lấy các contact từ client
        $contacts = $this->contactRepo->all(); // Hoặc lọc theo client nếu cần

        return view('admin.contacts.index', compact('contacts'));
    }

    // Xem chi tiết và trả lời
    public function show($id)
    {
        $contact = $this->contactRepo->find($id);

        return view('admin.contacts.show', compact('contact'));
    }

    // Gửi email phản hồi từ admin
    public function sendEmail(Request $request, $id)
    {
        $contact = $this->contactRepo->find($id);

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Mail::send('emails.reply_contact', [
            'contact' => $contact,
            'replyMessage' => $request->message
        ], function ($mail) use ($contact, $request) {
            $mail->to($contact->email)
                ->subject($request->subject);
        });

        // Mark contact as replied
        $this->contactRepo->markAsReplied($id);

        return redirect()->route('admin.contact.index')->with('success', 'Email đã được gửi thành công.');
    }
}
