//elementos do formulário de pesquisa
const formSearch = document.querySelector('.form-search');
const iconSearch = document.querySelector('.icon-search');

//elementos de menu lateral
const menuIcon = document.querySelector('.menu-icon');
const navbarAside = document.querySelector('aside');
const content = document.querySelector('.content');
const asideBtn = document.querySelector('.aside-btn-task');
const caretDropdown = document.querySelector('.caret');
const menuDropdown = document.querySelector('.dropdown .menu');
const selectDropdow = document.querySelector('.dropdown .select');
const optionsDropdown = document.querySelectorAll('.dropdown .menu li');

//elementos do formulário de criação de tarefas
const formCreate = document.querySelector('.form-create-task');
const inputBox = document.querySelector('.form-create-task .input-box');
const inputTask = document.querySelector('.form-create-task .input-box input');
const textAreaBox = document.querySelector('.form-create-task .textarea-box div');
const textAreaTask = document.querySelector('.form-create-task .textarea-box div textarea');
const selectBox = document.querySelector('.form-create-task .select-box select')
const iconClose = document.querySelector('.icon-close');
const btnSubmitTask = document.querySelector('.form-create-task .form-create .btn-task .btn');
const leavingFormTask = document.querySelector('.leaving-container');
const btnLeavingKeep = document.querySelector('.btn-leaving .keep');
const btnLeavingLeave = document.querySelector('.btn-leaving .leave');

//elementos do formulário de criação de cartegory
const formCreateCategory = document.querySelector('.form-create-category')
const asideBtnCategory = document.querySelector('.aside-btn-category');
const inputCategory = document.querySelector('.form-create-category input');
const inputBoxCategory = document.querySelector('.form-create-category .input-box');
const btnCancelCategory = document.querySelector('.form-create-category .btn .cancel');
const btnSubmitCategory = document.querySelector('.form-create-category .btn .submit');
const messageCategory = document.querySelector('.message-category');

//elementos do task item
const taskItem = document.querySelectorAll('.content .task-item');

taskItem.forEach((task, index) => {
    task.classList.remove('clicked');
    task.addEventListener('click', () => {
        taskItem.forEach(t => t.classList.remove('clicked'));
        task.classList.add('clicked');
    });

    task.querySelector('.task-dropdown .select').addEventListener('click', () => {
        task.querySelector('.task-dropdown .caret').classList.toggle('rotate');
        task.querySelector('.task-dropdown .task-container').classList.toggle('active');

    });

    task.querySelector('.icon-option').addEventListener('click', () => {

        const isActive = task.querySelector('.icon-option').classList.contains('active');
        document.querySelectorAll('.task-item .icon-option').forEach(i => i.classList.remove('active'));
        document.querySelectorAll('.task-item .category-options').forEach(opt => opt.classList.remove('active'));
        if (!isActive) {
            task.querySelector('.icon-option').classList.add('active');
            task.querySelector('.category-options').classList.add('active');
        }
    });

    task.querySelector('.add-task').addEventListener('click', () => {
        formCreate.classList.add('active-form');
    })

    task.querySelectorAll('.task-container .check .checkbox').forEach((check, index) => {
        check.addEventListener('click', () => {
            task.querySelectorAll('.task-container .check')[index].classList.toggle('checked');
        });
    })

    task.querySelectorAll('.task-container li').forEach((iten, index) => {
        iten.addEventListener('click', (e) => {

            const clickedElement = e.target;

            if (clickedElement.closest('.btn.edit') ||
                clickedElement.closest('.btn.save') ||
                clickedElement.closest('.btn.delete') ||
                clickedElement.closest('.task-text') ||
                clickedElement.closest('.task-details span') ||
                clickedElement.closest('.task-container .check .checkbox')
            ) return;
            else e.stopPropagation();
            const isActive = iten.classList.contains('active');
            task.querySelectorAll('.task-container li').forEach(i => i.classList.remove('active'));

            if (!isActive)
                iten.classList.add('active');
        })
    })

    task.querySelectorAll('.info-task').forEach(info => {
        const taskText = info.querySelector('.task-text');
        const btnEdit = info.querySelector('.btn.edit');
        const btnSave = info.querySelector('.btn.save');
        const textOld = taskText.textContent;
        if (!taskText || !btnEdit || !btnSave) return;

        function enterEditMode() {
            taskText.setAttribute('contenteditable', true);
            taskText.focus();
            btnEdit.style.display = 'none';
            btnSave.style.display = 'flex';
        }

        function exitEditMode() {
            if (taskItem.textContent === '') taskText.innerHTML = textOld;
            taskText.setAttribute('contenteditable', false);
            btnEdit.style.display = 'flex';
            btnSave.style.display = 'none';
        }

        taskText.addEventListener('click', enterEditMode);
        btnEdit.addEventListener('click', enterEditMode);

        btnSave.addEventListener('click', exitEditMode);

        taskText.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                exitEditMode();
            }
        })

        taskText.addEventListener('blur', () => {
            setTimeout(exitEditMode), 100
        });
    })

    task.querySelectorAll('.task-details span').forEach(details => {
        details.addEventListener('click', () => {
            if (details.textContent === 'Details') details.innerHTML = '';
            const isEditing = details.getAttribute('contenteditable') === 'true';
            details.setAttribute('contenteditable', !isEditing);
            details.focus();
        })

        function exitEditMode() {
            if (details.textContent === '') details.innerHTML = 'Details';
            details.setAttribute('contenteditable', false);
        }
        details.addEventListener('blur', exitEditMode);
        details.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                exitEditMode();
            }
        })
    })

    task.querySelector('.change-name').addEventListener('click', () => {
        const nameCategory = task.querySelector('.task-head p').textContent;
        formCreateCategory.querySelector('.input-box input').value = nameCategory;
        formCreateCategory.classList.add('active');
        btnSubmitCategory.classList.add('active');
    });
    task.querySelector('.delete-task-done').addEventListener('click', () => {
        formEliminate('Elimine tarefas concluídas',  'Todas as tarefas concluídas vão ser eliminadas permanentemente desta lista'
            , 'Cancelar', 'Eliminar');
    });

    task.querySelector('.delete-category').addEventListener('click', () => {
        formEliminate('Desejas eliminar a lista?',  ''
            , 'Cancelar', 'Eliminar');
    });


});

//colocando a visibilidade do formulário de tarefas
asideBtn.addEventListener('click', () => {
    formCreate.classList.add('active-form');
});

//colocando efeito nos elementos do formulário de criação de tarefa
inputTask.addEventListener('focus', () => {
    inputBox.classList.add('active');
});

inputTask.addEventListener('blur', () => {
    inputBox.classList.remove('active');
});

textAreaTask.addEventListener('focus', () => {
    textAreaBox.classList.add('active');
});

textAreaTask.addEventListener('blur', () => {
    textAreaBox.classList.remove('active')
});

selectBox.addEventListener('focus', () => {
    selectBox.classList.add('active');
});

selectBox.addEventListener('blur', () => {
    selectBox.classList.remove('active');
});

inputTask.addEventListener('input', () => {
    if (inputTask.value.length > 0)
        btnSubmitTask.classList.add('active');
    else
        btnSubmitTask.classList.remove('active');
});


iconClose.addEventListener('click', () => {
    if (inputTask.value.length > 0)
        leavingFormTask.classList.add('active');
    else
        formCreate.classList.remove('active-form');
});

btnLeavingKeep.addEventListener('click', () => {
    leavingFormTask.classList.remove('active');
});

btnLeavingLeave.addEventListener('click', () => {
    leavingFormTask.classList.remove('active');
    inputTask.value = '';
    textAreaTask.value = '';
    formCreate.classList.remove('active-form');
})

selectDropdow.addEventListener('click', () => {
    caretDropdown.classList.toggle('rotate');
    menuDropdown.classList.toggle('active');
})

optionsDropdown.forEach(option => {
    option.addEventListener('click', () => {
        option.classList.toggle('check');
    });
});

menuIcon.addEventListener('click', () => {
    navbarAside.classList.toggle('active-aside');
    content.classList.toggle('active');
});


iconSearch.addEventListener('click', () => {
    formSearch.classList.add('active-search');
});

asideBtnCategory.addEventListener('click', () => {
    formCreateCategory.classList.add('active');
});

btnCancelCategory.addEventListener('click', () => {
    inputCategory.value = '';
    messageCategory.classList.remove('active');
    formCreateCategory.classList.remove('active');
    btnSubmitCategory.classList.remove('active');
});

inputCategory.addEventListener('focus', () => {
    inputBoxCategory.classList.add('active');
});

inputCategory.addEventListener('blur', () => {
    inputBoxCategory.classList.remove('active');
});

inputCategory.addEventListener('input', () => {

    if (inputCategory.value.length > 0) {
        messageCategory.classList.remove('active');
        btnSubmitCategory.classList.add('active');
    } else {
        messageCategory.classList.add('active');
        btnSubmitCategory.classList.remove('active');
    }
});


function formEliminate(header, info = '', btn1 = 'Cancelar', btn2 = 'Rejeitar') {
    const form = leavingFormTask;
    const title = form.querySelector('.leaving-task-title');
    const btnKeep = form.querySelector('.btn-leaving .keep');
    const btnLeave = form.querySelector('.btn-leaving .leave');
    const leaving = form.querySelector('.leaving-task');
    const divBtn = leaving.querySelector('.btn-leaving');

    leaving.querySelectorAll('p.message-dynamic').forEach(p => p.remove());

    title.textContent = header;
    btnKeep.textContent = btn1;
    btnLeave.textContent = btn2;

    if (info) {
        const message = document.createElement('p');
        message.classList.add('message-dynamic');
        message.textContent = info;
        leaving.insertBefore(message, divBtn);
    }

    form.classList.add('active');
}

