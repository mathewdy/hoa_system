class AppState {
  constructor(config) {
    this.c = { 
      tableId: 'dataTable', 
      searchId: 'simple-search', 
      paginationId: 'paginationList', 
      limit: 10, 
      onLoading: () => this.showSkeleton(),
      onLoaded: () => this.clearSkeleton(),
      ...config 
    };
    this.state = { 
      data: [], 
      loading: false, 
      search: '', 
      pagination: { currentPage: 1, totalPages: 1, totalRecords: 0, limit: this.c.limit } 
    };
    this.init();
  }

  init() { 
    this.loadUrl(); 
    this.bind(); 
    this.fetch(); 
  }

  loadUrl() {
    const p = new URLSearchParams(location.search);
    this.state.pagination.currentPage = +p.get('page') || 1;
    this.state.search = p.get('search') || '';
    $(`#${this.c.searchId}`).val(this.state.search);
  }

  updateUrl() {
    const p = new URLSearchParams();
    if (this.state.pagination.currentPage > 1) p.set('page', this.state.pagination.currentPage);
    if (this.state.search) p.set('search', this.state.search);
    history.replaceState(null, '', `${location.pathname}?${p}` || location.pathname);
  }

  bind() {
    let t;
    $(document).off('input', `#${this.c.searchId}`).on('input', `#${this.c.searchId}`, () => {
      clearTimeout(t);
      t = setTimeout(() => {
        this.state.search = $(`#${this.c.searchId}`).val().trim();
        this.state.pagination.currentPage = 1;
        this.updateUrl(); 
        this.fetch();
      }, 100);
    });

    $(document).off('click', `#${this.c.paginationId} .page-btn`).on('click', `#${this.c.paginationId} .page-btn`, (e) => {
      e.preventDefault();
      const page = +(e.target.closest('a').dataset.page);
      if (page >= 1 && page <= this.state.pagination.totalPages) {
        this.state.pagination.currentPage = page;
        this.updateUrl(); 
        this.fetch();
      }
    });
  }

  fetch() {
    this.state.loading = true;
    this.c.onLoading?.();
    $.get(this.c.apiUrl, {
      page: this.state.pagination.currentPage,
      limit: this.state.pagination.limit,
      search: this.state.search
    }, (res) => {
      if (res.success) {
        this.state.data = res.data;
        this.state.pagination = { ...this.state.pagination, ...res.pagination };
      } else this.state.data = [];
      this.state.loading = false;
      this.c.onLoaded?.();
      this.render();
    }, 'json').fail(() => { 
      this.state.loading = false; 
      this.c.onLoaded?.();
      this.render(); 
    });
  }

  showSkeleton() {
    const $tbody = $(`#${this.c.tableId} tbody`);
    $tbody.empty();
    const cols = this.c.columns.length;
    const row = Array(cols).fill().map(() => 
      `<td class="px-6 py-4"><div class="h-4 bg-gray-200 rounded animate-pulse"></div></td>`
    ).join('');
    for (let i = 0; i < 5; i++) {
      $tbody.append(`<tr class="border-b">${row}</tr>`);
    }
  }

  clearSkeleton() {
    $(`#${this.c.tableId} tbody`).empty();
  }

  render() {
    const $tbody = $(`#${this.c.tableId} tbody`);
    const $pg = $(`#${this.c.paginationId}`);
    if (this.state.loading) return;

    $tbody.empty(); 
    $pg.empty();

    if (!this.state.data.length) {
      $tbody.append(`<tr><td colspan="${this.c.columns.length}" class="px-6 py-4 text-center text-gray-500">No records found.</td></tr>`);
      return;
    }

    this.state.data.forEach(row => {
      const cols = this.c.columns.map(c => c(row));
      $tbody.append(`<tr class="border-b hover:bg-gray-50">
        ${cols.map(c => `<td class="px-6 py-4">${c}</td>`).join('')}
      </tr>`);
    });

    this.renderPagination($pg);
  }

  renderPagination($pg) {
    const p = this.state.pagination;
    if (!p.totalRecords) return;

    const start = (p.currentPage - 1) * p.limit + 1;
    const end = Math.min(start + p.limit - 1, p.totalRecords);
    $('#rangeStart').text(start); 
    $('#rangeEnd').text(end); 
    $('#totalRecords').text(p.totalRecords);

    $pg.append(this.pagBtn(p.currentPage - 1, 'Previous', p.currentPage === 1));
    let s = Math.max(1, p.currentPage - 2), e = Math.min(p.totalPages, s + 4);
    if (e - s + 1 < 5) s = Math.max(1, e - 4);
    for (let i = s; i <= e; i++) $pg.append(this.pagBtn(i, i, i === p.currentPage));
    $pg.append(this.pagBtn(p.currentPage + 1, 'Next', p.currentPage === p.totalPages));
  }

  pagBtn(page, text, disabled) {
    const cls = disabled ? 'cursor-not-allowed opacity-50' : '';
    const active = page === this.state.pagination.currentPage 
      ? 'z-10 bg-teal-600 border-teal-600 text-white' 
      : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-100 hover:text-gray-700';
    const r = text === 'Previous' ? 'rounded-s-lg' : text === 'Next' ? 'rounded-e-lg' : '';
    return `<li><a href="#" data-page="${page}" class="page-btn flex items-center justify-center px-3 h-8 leading-tight border ${cls} ${active} ${r}">${text}</a></li>`;
  }
}