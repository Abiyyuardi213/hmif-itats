@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('page_title', 'Pesan & Aspirasi Masuk')

@section('content')
    <div class="space-y-4">
        @forelse($messages as $msg)
            <div class="rounded-2xl border border-line bg-white p-5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-display font-bold text-ink-950">{{ $msg->subject }}</span>
                            @if($msg->status === 'unread')
                                <span class="rounded-full bg-brand-100 px-2.5 py-0.5 font-mono text-xs font-semibold text-brand-800">BARU</span>
                            @endif
                        </div>
                        <div class="text-xs text-ink-500 mt-0.5">
                            Dari: <strong>{{ $msg->name }}</strong> ({{ $msg->email }}) &middot; {{ $msg->created_at->translatedFormat('d M Y, H:i') }}
                        </div>
                        <p class="mt-3 text-sm text-ink-700 whitespace-pre-line">{{ $msg->message }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($msg->status === 'unread')
                            <form method="POST" action="{{ route('admin.pesan.read', $msg) }}">
                                @csrf
                                <button type="submit" class="rounded-lg border border-line px-3 py-1.5 text-xs font-semibold">Tandai Dibaca</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.pesan.destroy', $msg) }}" onsubmit="return confirm('Hapus pesan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-danger bg-danger-surface px-3 py-1.5 text-xs font-semibold text-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-line bg-white p-10 text-center text-sm text-ink-500">
                Belum ada pesan masuk dari halaman Kontak.
            </div>
        @endforelse
        {{ $messages->links() }}
    </div>
@endsection
