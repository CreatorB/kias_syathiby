<div class="card">
    @isset($judul)
    <div class="card-header">
        <h4 class="card-title">{{ $judul }}</h4>
    </div>
    @endisset
    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
            {{ $slot }}
        </ul>
        <div class="tab-content">
            <div {{ $tab1->attributes->class(['tab-pane'])->merge(['id' => '', 'role' => 'tabpanel']) }}>
                {{ $tab1 }}
            </div>

            @isset($tab2)
            <div {{ $tab2->attributes->class(['tab-pane'])->merge(['id' => '', 'role' => 'tabpanel']) }}>
                {{ $tab2 }}
            </div>
            @endisset

            @isset($tab3)
            <div {{ $tab3->attributes->class(['tab-pane'])->merge(['id' => '', 'role' => 'tabpanel']) }}>
                {{ $tab3 }}
            </div>
            @endisset

            @isset($tab4)
            <div {{ $tab4->attributes->class(['tab-pane'])->merge(['id' => '', 'role' => 'tabpanel']) }}>
                {{ $tab4 }}
            </div>
            @endisset
        </div>
    </div>
</div>
