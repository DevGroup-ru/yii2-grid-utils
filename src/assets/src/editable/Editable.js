class Editable {
  constructor(options) {
    this.settings = options;

    this.bindListeners();
  }

  bindListeners() {
    $(document).on('change', this.settings.selector, function() {
      const $obj = $(this).hasClass('grid-input') ? $(this) : $(this).parent().find('.select2-selection');
      $obj
        .addClass('highlight-changes');
      setTimeout(() => {
        $obj.addClass('highlight-changes_ok');
        setTimeout(() => {
          $obj
            .removeClass('highlight-changes')
            .removeClass('highlight-changes_ok');
        }, 500);
      }, 1000);
    });
  }
}

export default Editable;