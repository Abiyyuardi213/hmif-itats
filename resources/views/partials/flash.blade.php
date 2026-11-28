@if(session('success'))
    <div class="mx-auto max-w-[1200px] px-4 sm:px-6 lg:px-8 pt-4">
        <div role="alert" class="rounded-[12px] border border-success bg-success-surface px-4 py-3 text-sm text-text flex items-start gap-2.5">
            <x-icon name="check-circle" size="18" class="text-success mt-0.5" />
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mx-auto max-w-[1200px] px-4 sm:px-6 lg:px-8 pt-4">
        <div role="alert" class="rounded-[12px] border border-danger bg-danger-surface px-4 py-3 text-sm text-text flex items-start gap-2.5">
            <x-icon name="alert-circle" size="18" class="text-danger mt-0.5" />
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    </div>
@endif

@if(isset($errors) && $errors->any())
    <div class="mx-auto max-w-[1200px] px-4 sm:px-6 lg:px-8 pt-4">
        <div role="alert" class="rounded-[12px] border border-danger bg-danger-surface px-4 py-3 text-sm text-text flex items-start gap-2.5">
            <x-icon name="alert-circle" size="18" class="text-danger mt-0.5" />
            <div>
                <div class="font-semibold mb-1">Periksa kembali data yang dikirimkan:</div>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
