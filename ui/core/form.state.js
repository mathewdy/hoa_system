class FormState {
  constructor(config) {
    this.c = {
      formId: '',
      apiUrl: '',
      idParam: 'id',
      onLoading: () => {}, 
      onLoaded: () => {},   
      ...config
    };
    this.state = { data: {}, loading: false };
    this.init();
  }

  init() {
    this.loadRecord();
  }

  getId() {
    const p = new URLSearchParams(window.location.search);
    return p.get(this.c.idParam) || null;
  }

  async loadRecord() {
    const id = this.getId();
    if (!id) return;

    this.state.loading = true;
    this.c.onLoading?.();

    try {
      const res = await $.getJSON(this.c.apiUrl, { [this.c.idParam]: id });
      if (res.success) {
        this.state.data = res.data || {};
        this.populateForm();
      } else {
        console.error(res.error || 'Failed to fetch record');
      }
    } catch (err) {
      console.error(err);
    } finally {
      this.state.loading = false;
      this.c.onLoaded?.();
    }
  }

  populateForm() {
    const $form = $(`#${this.c.formId}`);
    if (!$form.length) return;

    Object.entries(this.state.data).forEach(([key, value]) => {
      const $el = $form.find(`[name="${key}"]`);
      if ($el.length) {
        if ($el.is(':checkbox')) {
          $el.prop('checked', !!value);
        } else if ($el.is('select')) {
          $el.val(value).trigger('change');
        } else {
          $el.val(value ?? '');
        }
      }
    });
  }
}
