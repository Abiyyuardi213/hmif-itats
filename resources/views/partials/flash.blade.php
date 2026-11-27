@if(session('success'))
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-4">
        <div role="alert" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 flex items-start justify-between gap-3">
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-4">
        <div role="alert" class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-4">
        <div role="alert" class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
            <div class="font-semibold mb-1">Periksa kembali data yang dikirimkan:</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
