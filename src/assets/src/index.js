import './app.scss';
import Editable from './editable/Editable';

class GridUtils {
  constructor() {
    this.init();
  }

  init() {
    const userSettings = window.GridUtilsSettings || {};
    const settings = {
      editableOptions: {
        selector: '.grid-utils'
      }
    };
    Object.keys(userSettings).forEach(key => {
      settings[key] = userSettings[key];
    });
    this.settings = settings;

    this.Editable = new Editable(this.settings.editableOptions);
  }
}

window.GridUtils = new GridUtils();


