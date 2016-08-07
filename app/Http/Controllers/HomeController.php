<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Eloquents\CatEloquent;
use App\Eloquents\TagEloquent;
use Validator;
use Mail;
use Option;

class HomeController extends Controller {

    protected $cat;
    protected $tag;

    public function __construct(CatEloquent $cat, TagEloquent $tag) {
        $this->cat = $cat;
        $this->tag = $tag;
    }

    public function index() {
        $cats = $this->cat->all([
            'fields' => ['taxs.id', 'taxs.count', 'td.name', 'td.slug']
        ]);
        $tags = $this->tag->all([
            'fields' => ['taxs.id', 'taxs.count', 'td.name', 'td.slug']
        ]);

        return view('front.index', compact('cats', 'tags'));
    }

    public function sendContact(Request $request) {
        $valid = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required',
                    'content' => 'required'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }

        $mail_to = Option::get('_admin_email');
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'content' => $request->input('content'),
            'phone' => $request->input('phone')
        ];

        Mail::send('mails.contact', $data, function($mail) use($mail_to, $request) {
            $mail->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
            $mail->to($mail_to);
            $mail->subject(trans('contact.subject_content', ['host' => $request->getHost()]));
        });

        if (count(Mail::failures()) > 0) {
            return redirect()->back()->withInput()->with('error_mess', trans('front.na_errors'));
        }

        return redirect()->back()->with('succ_mess', trans('contact.contact_sent'));
    }

}
