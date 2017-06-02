class Editable {
  constructor(options) {
    this.settings = options;

    this.bindListeners();
  }

  bindListeners() {
    const that = this;
    $(document).on('change', this.settings.selector, function() {
      const $obj = $(this);
      $obj
        .addClass('highlight-changes');
      const route = $obj.data('route');
      const id = $obj.data('id');
      const attribute = $obj.data('attribute');
      const value = $obj.val();
      console.log($obj);
      $.ajax({
        url: route,
        method: 'post',
        dataType: 'json',
        cache: false,
        data: {
          id,
          attribute,
          value,
          _csrf: $('meta[name="csrf-token"]').attr('content')
        },
        success(result) {
          if (result) {
            that.showOk($obj);
          } else {
            that.showError($obj);
          }
        },
        error() {
          that.showError($obj);
        }
      });
    });
  }

  showOk($obj) {
    $obj.addClass('highlight-changes_ok');
    setTimeout(() => {
      $obj
        .removeClass('highlight-changes')
        .removeClass('highlight-changes_ok');
    }, 500);
    if (window.gridUtilsEditableSuccessCallback) {
      window.gridUtilsEditableSuccessCallback();
    }
  }

  showError($obj) {
    $obj.addClass('highlight-changes_error');
    setTimeout(() => {
      $obj
        .removeClass('highlight-changes')
        .removeClass('highlight-changes_error');
    }, 1500);
  }
}

export default Editable;