<div
    id="logoutModal"
    data-modal
    role="dialog"
    aria-modal="true"
    aria-labelledby="logoutModalTitle"
    class="hidden fixed inset-0 z-50 items-center justify-center bg-scrim p-4"
>
    <div class="w-full max-w-md rounded-[20px] border border-border bg-surface-raised p-6 shadow-card">
        <h3 id="logoutModalTitle" class="font-display text-lg font-bold text-text">Konfirmasi keluar</h3>
        <p class="mt-2 text-sm text-text-muted">
            Apakah Anda yakin ingin mengakhiri sesi pengurus saat ini?
        </p>
        <div class="mt-6 flex items-center justify-end gap-3">
            <x-button type="button" variant="secondary" data-modal-close>
                Batal
            </x-button>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="min-h-11 inline-flex items-center justify-center rounded-full border-2 border-danger bg-danger-surface px-5 py-2.5 text-sm font-semibold text-text hover:bg-bg-soft transition-colors"
                >
                    Ya, keluar
                </button>
            </form>
        </div>
    </div>
</div>
