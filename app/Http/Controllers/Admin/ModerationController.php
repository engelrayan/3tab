<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atab;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    public function index(Request $request)
    {
        $customWords = SystemSetting::jsonArray('custom_blocked_words');
        $configWords = config('abuse.blocked_words', []);

        $flaggedQ = Atab::with(['sender', 'receiver'])
            ->where('is_flagged', true);

        if ($request->input('q')) {
            $flaggedQ->whereHas('messages', fn($m) => $m->where('body', 'like', '%'.$request->q.'%'));
        }

        $flaggedAtabs = $flaggedQ->latest()->paginate(15)->withQueryString();

        return view('admin.moderation', compact('customWords', 'configWords', 'flaggedAtabs'));
    }

    public function addWord(Request $request)
    {
        $request->validate(['word' => ['required', 'string', 'min:2', 'max:40']]);
        $word  = trim($request->word);
        $words = SystemSetting::jsonArray('custom_blocked_words');

        if (!in_array($word, $words)) {
            $words[] = $word;
            SystemSetting::setArray('custom_blocked_words', $words);
        }

        return response()->json(['success' => true, 'words' => $words]);
    }

    public function removeWord(Request $request)
    {
        $request->validate(['word' => ['required', 'string']]);
        $words = SystemSetting::jsonArray('custom_blocked_words');
        $words = array_values(array_filter($words, fn($w) => $w !== $request->word));
        SystemSetting::setArray('custom_blocked_words', $words);
        return response()->json(['success' => true, 'words' => $words]);
    }

    public function unflag(Atab $atab)
    {
        $atab->update(['is_flagged' => false]);
        return response()->json(['success' => true]);
    }

    public function destroyFlagged(Atab $atab)
    {
        $atab->delete();
        return response()->json(['success' => true]);
    }
}
