import EditorJS from '@editorjs/editorjs';

const saveDataForm = document.getElementById('save-data-form');

if (saveDataForm) {
  const toEditorJs = document.getElementById('to-editorjs');

  // Initial Editor JS
  const editor = new EditorJS({

    holder: 'editorjs',

    tools: {
      paragraph: {
        toolbox: {
          title: 'Текст'
        }
      },
    },
    // Передача данных в редактор при инициализации
    // data: toEditorJs ? JSON.parse(toEditorJs.innerText) : '',
    /**
     * Документация
     * https://github.com/codex-team/editor.js/blob/next/example/example-i18n.html
     */
    i18n: {
      /**
       * @type {I18nDictionary}
       */
      messages: {
        "ui": {
          "blockTunes": {
            "toggler": {
              "Click to tune": "Нажмите, чтобы настроить",
              "or drag to move": "или перетащите"
            },
          },
          "inlineToolbar": {
            "converter": {
              "Convert to": "Конвертировать в"
            }
          },
          "toolbar": {
            "toolbox": {
              "Add": "Добавить",
            }
          },
          "popover": {
            "Filter": "Поиск",
            "Nothing found": "Ничего не найдено"
          }
        },
        "toolNames": {
          "Text": "Параграф",
          "Heading": "Заголовок",
          "List": "Список",
          "Warning": "Примечание",
          "Checklist": "Чеклист",
          "Quote": "Цитата",
          "Code": "Код",
          "Delimiter": "Разделитель",
          "Raw HTML": "HTML-фрагмент",
          "Table": "Таблица",
          "Link": "Ссылка",
          "Marker": "Маркер",
          "Bold": "Полужирный",
          "Italic": "Курсив",
          "InlineCode": "Моноширинный",
          "Image": "Картинка"
        },
        "tools": {
          "warning": {
            "Title": "Название",
            "Message": "Сообщение",
          },
          "link": {
            "Add a link": "Вставьте ссылку"
          },
          "stub": {
            'The block can not be displayed correctly.': 'Блок не может быть отображен'
          },
          "image": {
            "Caption": "Подпись",
            "Select an Image": "Выберите файл",
            "With border": "Добавить рамку",
            "Stretch image": "Растянуть",
            "With background": "Добавить подложку",
          },
          "code": {
            "Enter a code": "Код",
          },
          "linkTool": {
            "Link": "Ссылка",
            "Couldn't fetch the link data": "Не удалось получить данные",
            "Couldn't get this link data, try the other one": "Не удалось получить данные по ссылке, попробуйте другую",
            "Wrong response format from the server": "Неполадки на сервере",
          },
          "header": {
            "Header": "Заголовок",
          },
          "paragraph": {
            "Enter something": "Введите текст"
          },
          "list": {
            "Ordered": "Нумерованный",
            "Unordered": "Маркированный",
          },
          "attaches": {
            "Select file to upload": "Выберите файл"
          }
        },
        "blockTunes": {
          "delete": {
            "Delete": "Удалить"
          },
          "moveUp": {
            "Move up": "Переместить вверх"
          },
          "moveDown": {
            "Move down": "Переместить вниз"
          }
        },
      }
    },
    data: (toEditorJs && toEditorJs.innerText) ? JSON.parse(toEditorJs.innerText) : ''
  });

  // Отправка формы с перезагрузкой
  const saveDataInput = document.getElementById('save-data-input');

  saveDataForm.onsubmit = function(e) {
    // Отменяю отправку формы
    e.preventDefault();

    // Сохраняю данные из editor js
    editor.save()
    .then((savedData) => {
      // Присваиваю saveDataInput.value значение savedData в виде строки
      saveDataInput.value = JSON.stringify(savedData);

      // Если данные есть, то отправляю форму
      // if (savedData.blocks.length > 0) {
        saveDataForm.submit();
      // }
    })
    .catch((error) => {
      console.error('Saving error', error);
    });



  }

  // Передача данных в редактор после инициализации
  // if (toEditorJs && toEditorJs.innerText) {
  //   editor.data = JSON.parse(toEditorJs.innerText);
  // }

}