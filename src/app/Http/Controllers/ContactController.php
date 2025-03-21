<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Response; // CSVダウンロード用に追加

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('contact.index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->all();

        $category = Category::find($request->category_id);

        return view('contact.confirm', compact('contact', 'category'));

    }

        public function store(ContactRequest $request)
        {
            $action = $request->input('action');

            $contact = $request->except(['_token', 'action']);

            if($action === 'back') {
                return redirect()->route('contact.index')->withInput($contact);

            }

            Contact::create($contact);
            return redirect()->route('contact.thanks');
        }

    public function thanks()
    {
        return view('contact.thanks');
    }
    // 管理者ページ
    public function admin()
    {
        $contacts = Contact::with('category')->paginate(7);
        $categories = Category::all();
        return view('admin.index', compact('contacts', 'categories'));
    }

    public function search(Request $request)
    {
        $contacts = Contact::name($request->input('name'))
            ->gender($request->input('gender'))
            ->email($request->input('email'))
            ->category($request->input('category_id'))
            ->createdBetween($request->input('date_from'), $request->input('date_to'))
            ->with('category')
            ->paginate(7)
            ->appends($request->query()); // クエリパラメータを保持

        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.show', compact('contact')); // モーダルで表示
    }

    public function destroy($id)
    {
        Contact::find($id)->delete();
        return redirect()->route('admin.index')->with('message', 'お問い合わせを削除しました');
    }


    public function export(Request $request)
    {
        $query = Contact::query();

        // 検索条件 (search メソッドと同様)
        $query->name($request->input('name'))
            ->gender($request->input('gender'))
            ->email($request->input('email'))
            ->category($request->input('category_id'))
            ->createdBetween($request->input('date_from'), $request->input('date_to'));

        $contacts = $query->with('category')->get(); // 全件取得

        // CSV データを作成
        $csvHeader = ['ID', '姓', '名', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせの種類', '詳細', '作成日', '更新日'];
        $csvData = [$csvHeader];

        foreach ($contacts as $contact) {
            $csvRow = [
                $contact->id,
                $contact->first_name,
                $contact->last_name,
                $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'),
                $contact->email,
                $contact->tel,
                $contact->address,
                $contact->building,
                $contact->category->content,
                $contact->detail,
                $contact->created_at,
                $contact->updated_at,
            ];
            $csvData[] = $csvRow;
        }

        // CSV レスポンスを返す
        // 一時ファイルを作成
        $tempFilePath = tempnam(sys_get_temp_dir(), 'csv');
        $handle = fopen($tempFilePath, 'w');

        if ($handle === FALSE) {
            die('Could not open temp file');
        }

       stream_filter_prepend($handle,'convert.iconv.utf-8/cp932//TRANSLIT'); //Windows対応 文字化け対策

        // CSVデータを書き込む
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        // CSV レスポンスを返す（ダウンロード）
        return Response::download($tempFilePath, 'contacts.csv', [
          'Content-Type' => 'text/csv; charset=cp932', //文字コード指定
        ])->deleteFileAfterSend(true); // 一時ファイルを削除
    }
}