<?php

namespace Tests\Feature;

use Tests\TestCase;

class StatStripComponentTest extends TestCase
{
    public function test_stat_strip_hides_zero_and_empty_stats_while_keeping_nonzero_values(): void
    {
        $view = $this->blade(<<<'BLADE'
            <x-stat-strip :stats="[
                ['value' => 4, 'label' => 'Divisi'],
                ['value' => 0, 'label' => 'Nilai nol integer'],
                ['value' => '0', 'label' => 'Nilai nol string'],
                ['value' => null, 'label' => 'Nilai null'],
                ['value' => '', 'label' => 'Nilai kosong'],
                ['value' => 34, 'label' => 'Pengurus'],
            ]" />
        BLADE);

        $view->assertSee('Divisi')
            ->assertSee('34')
            ->assertSee('Pengurus')
            ->assertDontSee('Nilai nol integer')
            ->assertDontSee('Nilai nol string')
            ->assertDontSee('Nilai null')
            ->assertDontSee('Nilai kosong');
    }

    public function test_stat_strip_renders_nothing_when_all_values_are_zero_or_empty(): void
    {
        $view = $this->blade(<<<'BLADE'
            <x-stat-strip :stats="[
                ['value' => 0, 'label' => 'Divisi'],
                ['value' => '0', 'label' => 'Program kerja'],
                ['value' => '', 'label' => 'Kegiatan'],
            ]" />
        BLADE);

        $this->assertSame('', trim((string) $view));
    }
}
