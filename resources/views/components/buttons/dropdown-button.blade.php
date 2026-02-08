<div>
    <button {{ $attributes->class(['btn btn-sm btn-icon'])->merge(['type' => 'button', 'data-bs-toggle' => 'dropdown', 'aria-expanded' => 'false']) }}>
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-clipboard">
            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2">
            </path>
            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
        </svg>
    </button>

    <div class="dropdown-menu">
        <a {{ $item1->attributes->class(['dropdown-item'])->merge(['href' => '#']) }}>
            {{ $item1 }}
        </a>

        <!--ITEM 2-->
        @isset($item2)
        <a {{ $item2->attributes->class(['dropdown-item'])->merge(['href' => '#']) }}>
            {{ $item2 }}
        </a>
        @endisset

        <!--ITEM 3-->
        @isset($item3)
        <a {{ $item3->attributes->class(['dropdown-item'])->merge(['href' => '#']) }}>
            {{ $item3 }}
        </a>
        @endisset

        <!--ITEM 4-->
        @isset($item4)
        <a {{ $item4->attributes->class(['dropdown-item'])->merge(['href' => '#']) }}>
            {{ $item4 }}
        </a>
        @endisset

    </div>

</div>
