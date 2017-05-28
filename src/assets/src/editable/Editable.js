class Editable {
  constructor(options) {
    this.settings = options;

    this.bindListeners();
  }

  bindListeners() {
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
        success() {
          $obj.addClass('highlight-changes_ok');
          setTimeout(() => {
            $obj
              .removeClass('highlight-changes')
              .removeClass('highlight-changes_ok');
          }, 500);
        },
        error() {
          $obj.addClass('highlight-changes_error');
          setTimeout(() => {
            $obj
              .removeClass('highlight-changes')
              .removeClass('highlight-changes_error');
          }, 1500);
        }
      });
    });
  }
}

export default Editable;