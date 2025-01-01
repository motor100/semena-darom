// Common
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Функция отключения скролла у input type=number
function disableScrollInputNumber() {

  let numberInputs = document.querySelectorAll('.input-number');

  numberInputs.forEach((item) => {
    item.onwheel = function(e) {
      e.preventDefault();
    }
  });

  return false;
}

// Отключение скролла у input type=number
disableScrollInputNumber();


// Input phone mask
let phoneElements = document.querySelectorAll('.phone-mask');

phoneElements.forEach((item) => {
  let maskOptionsPhone = {
    mask: '+{7} (000) 000 00 00'
  };
  let mask = IMask(item, maskOptionsPhone);
});

// Выбор файла Изображение
let inputMainFile = document.querySelector('#input-main-file'),
    mainFileText = document.querySelector('.main-file-text');

if (inputMainFile) {
  inputMainFile.onchange = function() {
    mainFileText.innerHTML = this.files[0].name;
  }
}


// Translate route to confirmDeleteModal
const confirmDeleteModal = document.getElementById('confirmDeleteModal');

if (confirmDeleteModal) {
  const cancelBtn = document.getElementById('cancel-btn');
  const delBtn = document.querySelectorAll('.del-btn');
  const deleteForm = document.getElementById('delete-form');

  delBtn.forEach((item) => {
    item.addEventListener('click', () => {
      deleteForm.action = item.dataset.route;
      confirmDeleteModal.onfocus = function() {
        cancelBtn.focus();
      }
    });
  });
}
