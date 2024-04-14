<div class="tabs-menu">
    <ul class="list tab-list">
        <li class="tab-option option_import active">
            <p class="option-text">Импорт статей</p>
        </li>
        <li class="tab-option option_search">
            <p class="option-text">Поиск</p>
        </li>
    </ul>
</div>

@script
<script>
    const import_nav = document.querySelector(".option_import");
    const search_nav = document.querySelector(".option_search");

    const search_tab = document.querySelector(".tab_search");
    const import_tab = document.querySelector(".tab_import");

    search_nav.addEventListener('click', () => {
        search_nav.classList.add('active');
        import_nav.classList.remove('active');

        search_tab.classList.add('tab_active');
        import_tab.classList.remove('tab_active');
    });

    import_nav.addEventListener('click', () => {
        import_nav.classList.add('active');
        search_nav.classList.remove('active');

        import_tab.classList.add('tab_active');
        search_tab.classList.remove('tab_active');
    });
</script>
@endscript
