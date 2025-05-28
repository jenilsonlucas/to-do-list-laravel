const csrf_token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

const url = window.location.origin;
let callbackResponse = null;

//elementos do formulário de pesquisa
const formSearch = document.querySelector(".form-search");
const iconSearch = document.querySelector(".icon-search");

//elementos de menu lateral
const menuIcon = document.querySelector(".menu-icon");
const navbarAside = document.querySelector("aside");
const content = document.querySelector(".content");
const asideBtn = document.querySelector(".aside-btn-task");
const caretDropdown = document.querySelector(".caret");
const menuDropdown = document.querySelector(".dropdown .menu");
const selectDropdow = document.querySelector(".dropdown .select");
const optionsDropdown = document.querySelectorAll(".dropdown .menu li");

//elementos do formulário de criação de tarefas
const formCreate = document.querySelector(".form-create-task");
const inputBox = document.querySelector(".form-create-task .input-box");
const inputTask = document.querySelector(".form-create-task .input-box input");
const textAreaBox = document.querySelector(
    ".form-create-task .textarea-box div"
);

// const btnSendTask = document.querySelector(".form-create-task");

const textAreaTask = document.querySelector(
    ".form-create-task .textarea-box div textarea"
);
const selectBox = document.querySelector(
    ".form-create-task .select-box select"
);
const iconClose = document.querySelector(".icon-close");
const btnSubmitTask = document.querySelector(
    ".form-create-task .form-create .btn-task .btn"
);
const leavingFormTask = document.querySelector(".leaving-container");
const btnLeavingKeep = document.querySelector(".btn-leaving .keep");
const btnLeavingLeave = document.querySelector(".btn-leaving .leave");

//elementos do formulário de criação de cartegory
const formCreateCategory = document.querySelector(".form-create-category");
const asideBtnCategory = document.querySelector(".aside-btn-category");
const inputCategory = document.querySelector(
    ".form-create-category .input-box input"
);
const inputBoxCategory = document.querySelector(
    ".form-create-category .input-box"
);
const btnCancelCategory = document.querySelector(
    ".form-create-category .btn .cancel"
);
const btnSubmitCategory = document.querySelector(
    ".form-create-category .btn .submit"
);
const messageCategory = document.querySelector(".message-category");

//elementos do task item
const taskItem = document.querySelectorAll(".content .task-item");

taskItem.forEach((task) => {
    task.classList.remove("clicked");
    task.addEventListener("click", () => {
        taskItem.forEach((t) => t.classList.remove("clicked"));
        task.classList.add("clicked");
    });

    task.querySelector(".task-dropdown .select")?.addEventListener(
        "click",
        () => {
            task.querySelector(".task-dropdown .caret").classList.toggle(
                "rotate"
            );
            task.querySelector(
                ".task-dropdown .task-container"
            ).classList.toggle("active");
        }
    );

    task.querySelector(".icon-option").addEventListener("click", () => {
        const isActive = task
            .querySelector(".icon-option")
            .classList.contains("active");
        document
            .querySelectorAll(".task-item .icon-option")
            .forEach((i) => i.classList.remove("active"));
        document
            .querySelectorAll(".task-item .category-options")
            .forEach((opt) => opt.classList.remove("active"));
        if (!isActive) {
            task.querySelector(".icon-option").classList.add("active");
            task.querySelector(".category-options").classList.add("active");
        }
    });

    task.querySelector(".add-task").addEventListener("click", () => {
        const nomeCategory = task.querySelector(".task-head p").textContent;

        const select = formCreate.querySelector("select");
        for (let option of select.options) {
            if (option.text === nomeCategory) {
                select.value = option.value;
                break;
            }
        }
        formCreate.classList.add("active");
    });

    task.querySelectorAll(".task-container .check .checkbox")?.forEach(
        (check) => {
            check.addEventListener("click", () => {
                check.closest(".check").classList.toggle("checked");

                const action = check.getAttribute("data-action");
                const id = check.getAttribute("data-id");
                const status = !Number(check.getAttribute("data-status"));

                const data = {
                    id: id,
                    completed: status,
                    _token: csrf_token,
                    _method: "PUT",
                };
                if (sendModal(action, data)) {
                    const li = check.closest("li");
                    const count = task.querySelector(".select .selected span");

                    if (status) {
                        count.textContent = String(
                            Number(count.textContent) + 1
                        );
                        check.setAttribute("data-status", "1");
                        var container =
                            task.querySelectorAll(".task-container")[1];
                    } else {
                        count.textContent = String(
                            Number(count.textContent) - 1
                        );
                        check.setAttribute("data-status", "0");
                        var container = task.querySelector(
                            ".task-container.first"
                        );
                    }
                    container.prepend(li);
                }
            });
        }
    );

    task.querySelectorAll(".task-container li").forEach((iten) => {
        iten.addEventListener("click", (e) => {
            const clickedElement = e.target;

            if (
                clickedElement.closest(".btn.edit") ||
                clickedElement.closest(".btn.save") ||
                clickedElement.closest(".btn.delete") ||
                clickedElement.closest(".task-text") ||
                clickedElement.closest(".task-details span") ||
                clickedElement.closest(".task-container .check .checkbox")
            )
                return;
            else e.stopPropagation();
            const isActive = iten.classList.contains("active");
            task.querySelectorAll(".task-container li").forEach((i) =>
                i.classList.remove("active")
            );

            if (!isActive) iten.classList.add("active");
        });
    });

    task.querySelectorAll(".info-task").forEach((info) => {
        const taskText = info.querySelector(".task-text");
        const btnEdit = info.querySelector(".btn.edit");
        const btnSave = info.querySelector(".btn.save");
        const btnDelete = info.querySelector(".btn.delete");
        const textOld = taskText.textContent;

        btnDelete.addEventListener("click", () => {
            const container = btnDelete.closest(".task-container");

            if (!container.classList.contains("first")) {
                const count = task.querySelector(".select .selected span");

                count.textContent = String(Number(count.textContent) - 1);
            }
            deleteTaskCategory(btnDelete, info);
        });

        taskText?.addEventListener("click", (e) => {
            e.stopPropagation();
            if (taskText.getAttribute("contenteditable") === "true") return;
            enterEditMode({ text: taskText, btnEdit, btnSave });
        });
        btnEdit?.addEventListener("click", (e) => {
            e.stopPropagation();
            if (taskText.getAttribute("contenteditable") === "true") return;
            enterEditMode({ text: taskText, btnEdit, btnSave });
        });

        btnSave?.addEventListener("click", (e) => {
            e.stopPropagation();
            exitEditMode({ taskText, textOld, btnEdit, btnSave });
        });

        taskText.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                exitEditMode({ taskText, textOld, btnEdit, btnSave });
            }
        });

        taskText?.addEventListener("blur", () => {
            setTimeout(() => {
                exitEditMode({ taskText, textOld, btnEdit, btnSave });
            }, 100);
        });
    });

    task.querySelectorAll(".task-details span").forEach((details) => {
        const li = details.closest("li");

        const btnEdit = li.querySelector(".btn.edit");
        const btnSave = li.querySelector(".btn.save");
        details.addEventListener("click", (e) => {
            e.stopPropagation();
            enterEditMode({ text: details, btnEdit, btnSave });
        });

        details.addEventListener("blur", (e) => {
            e.stopPropagation();
            setTimeout(() => {
                exitEditMode({ details, btnEdit, btnSave });
            }, 100);
        });

        details.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                exitEditMode({ details, btnEdit, btnSave });
            }
        });
    });

    task.querySelector(".change-name").addEventListener("click", (e) => {
        const nameCategory = task.querySelector(".task-head p").textContent;
        let method = formCreateCategory.querySelector('input[name="_method"]');
        const form = formCreateCategory.querySelector("form");
        const inputID = document.createElement("input");
        inputID.type = "hidden";
        inputID.name = "id";
        inputID.value = e.target.getAttribute("data-id");
        form.append(inputID);

        method.value = "PUT";

        formCreateCategory.querySelector(".input-box input").value =
            nameCategory;
        form.setAttribute("action", e.target.getAttribute("data-action"));

        formCreateCategory.classList.add("active");
        btnSubmitCategory.classList.add("active");
    });
    task.querySelector(".delete-task-done").addEventListener("click", () => {
        formEliminate(
            "Elimine tarefas concluídas",
            "Todas as tarefas concluídas vão ser eliminadas permanentemente desta lista",
            "Cancelar",
            "Eliminar"
        );
    });

    task.querySelector(".delete-category").addEventListener("click", (e) => {
        formEliminate(
            "Desejas eliminar a lista?",
            "",
            "Cancelar",
            "Eliminar",
            () => {
                const btnDelete = e.target;
                deleteTaskCategory(btnDelete, task);
                removeFormTask(btnDelete.getAttribute("data-id"));
                removeMenuList(btnDelete.getAttribute("data-id"));
            }
        );
    });
});

asideBtn.addEventListener("click", () => {
    formCreate.classList.add("active");
});

inputTask.addEventListener("focus", () => {
    inputBox.classList.add("active");
});

inputTask.addEventListener("blur", () => {
    inputBox.classList.remove("active");
});

textAreaTask.addEventListener("focus", () => {
    textAreaBox.classList.add("active");
});

textAreaTask.addEventListener("blur", () => {
    textAreaBox.classList.remove("active");
});

selectBox.addEventListener("focus", () => {
    selectBox.classList.add("active");
});

selectBox.addEventListener("blur", () => {
    selectBox.classList.remove("active");
});

inputTask.addEventListener("input", () => {
    if (inputTask.value.length > 0) btnSubmitTask.classList.add("active");
    else btnSubmitTask.classList.remove("active");
});

iconClose.addEventListener("click", () => {
    if (inputTask.value.length > 0) leavingFormTask.classList.add("active");
    else formCreate.classList.remove("active");
});

btnLeavingKeep.addEventListener("click", () => {
    leavingFormTask.classList.remove("active");
});

btnLeavingLeave.addEventListener("click", () => {
    if (callbackResponse) {
        callbackResponse();
        callbackResponse = null;
        leavingFormTask.classList.remove("active");
    } else {
        leavingFormTask.classList.remove("active");
        inputTask.value = "";
        textAreaTask.value = "";
        formCreate.classList.remove("active");
    }
});

selectDropdow.addEventListener("click", () => {
    caretDropdown.classList.toggle("rotate");
    menuDropdown.classList.toggle("active");
});

optionsDropdown.forEach((option) => {
    option.addEventListener("click", () => {
        option.classList.toggle("check");
        taskItem.forEach((task) => {
            const idList = task
                .querySelector(".list__id")
                .getAttribute("data-id");

            const idMenu = option.getAttribute("data-id");

            if (idList === idMenu) {
                task.classList.toggle("hidden");

                if (task.classList.contains("hidden")) {
                    setTimeout(() => {
                        task.style.display = "none";
                    }, 500);
                } else {
                    task.style.display = "block";
                }
            }
        });
    });
});

menuIcon.addEventListener("click", () => {
    navbarAside.classList.toggle("active-aside");
    content.classList.toggle("active");
});
const closeMenu = (e) => {
    if (e.key === "Escape" || e.key === "Esc") {
        navbarAside.classList.toggle("active-aside");
        content.classList.toggle("active");
    }
};

document.addEventListener("keydown", closeMenu);

iconSearch.addEventListener("click", () => {
    formSearch.classList.add("active-search");
});

asideBtnCategory.addEventListener("click", () => {
    formCreateCategory.classList.add("active");
});

btnCancelCategory.addEventListener("click", () => {
    inputCategory.value = "";
    messageCategory.classList.remove("active");
    formCreateCategory.classList.remove("active");
    btnSubmitCategory.classList.remove("active");
});

inputCategory.addEventListener("focus", () => {
    inputBoxCategory.classList.add("active");
});

inputCategory.addEventListener("blur", () => {
    inputBoxCategory.classList.remove("active");
});

inputCategory.addEventListener("input", () => {
    if (inputCategory.value.length > 0) {
        messageCategory.classList.remove("active");
        btnSubmitCategory.classList.add("active");
    } else {
        messageCategory.classList.add("active");
        btnSubmitCategory.classList.remove("active");
    }
});

function formEliminate(
    header,
    info = "",
    btn1 = "Cancelar",
    btn2 = "Rejeitar",
    onConfirm = "null"
) {
    const form = leavingFormTask;
    const title = form.querySelector(".leaving-task-title");
    const btnKeep = form.querySelector(".btn-leaving .keep");
    const btnLeave = form.querySelector(".btn-leaving .leave");
    const leaving = form.querySelector(".leaving-task");
    const divBtn = leaving.querySelector(".btn-leaving");

    leaving.querySelectorAll("p.message-dynamic").forEach((p) => p.remove());

    title.textContent = header;
    btnKeep.textContent = btn1;
    btnLeave.textContent = btn2;

    if (info) {
        const message = document.createElement("p");
        message.classList.add("message-dynamic");
        message.textContent = info;
        leaving.insertBefore(message, divBtn);
    }
    callbackResponse = onConfirm;
    form.classList.add("active");
}
document.querySelectorAll('form:not([data-send="false"])').forEach((form) => {
    if (form.dataset.listenerAttached === "true") return; // evita duplicar listener
    form.dataset.listenerAttached = "true";

    form.addEventListener("submit", async function (e) {
        e.preventDefault();
        const flash = document.querySelector(".ajax-response");
        const message = flash.querySelector(".ajax-response__message");
        const parent = form.closest(".active");
        const formData = new FormData(form);
        if (
            formData.has("description") &&
            !formData.get("description").trim()
        ) {
            formData.set("description", "Descrição");
        }

        const action = form.getAttribute("action");
        const method = form.getAttribute("method").toUpperCase();

        const myheaders = new Headers({
            Accept: "application/json",
        });

        const options = {
            method: method,
            headers: myheaders,
            body: formData,
        };
        try {
            const response = await fetch(action, options);
            if (!response.ok) {
                throw new Error(`Response status ${response.status}`);
            }

            parent.classList.remove("active");
            const data = await response.json();
            if (data.category) addCategory(data.category);
            else if(data.task) addTask(data.task);
            if(data.redirect) {
                window.location.href = data.redirect;
                return;
            }    
            if (data.message) {
                message.innerHTML = data.message;
                flash.classList.add("active");
            }

            setTimeout(() => {
                flash.classList.remove("active");
            }, 3000);


        } catch (error) {
            console.error(error.message);
        }
        form.reset();
    });
});

function addTask(task) {
    const categoryId = task.category_id;
    const categoryContainer = document.querySelector(`#category-${categoryId}`);

    const taskContainer = categoryContainer.parentElement.querySelector(
        ".task-container.first"
    );
    const li = document.createElement("li");

    const infoDiv = document.createElement("div");
    infoDiv.classList.add("info-task");

    const checkDiv = document.createElement("div");
    checkDiv.classList.add("check");

    const checkbox = document.createElement("span");
    checkbox.setAttribute("data-id", task.id);
    checkbox.setAttribute("data-status", "0");
    checkbox.setAttribute("data-action", `${url}/tarefas/${task.id}`);
    checkbox.classList.add("checkbox");

    const taskText = document.createElement("span");
    taskText.classList.add("task-text");
    taskText.setAttribute("contenteditable", "false");
    taskText.textContent = task.name ? task.name : "nome da tarefa";

    checkDiv.append(checkbox);
    checkDiv.append(taskText);

    const optionDiv = document.createElement("div");
    optionDiv.classList.add("task-option");

    const btnEdit = document.createElement("button");
    btnEdit.classList.add("btn", "edit");
    btnEdit.innerHTML = `<i class='bx bxs-edit-alt'></i>`;

    const btnSave = document.createElement("button");
    btnSave.classList.add("btn", "save");
    btnSave.setAttribute("data-id", task.id);
    btnSave.setAttribute("data-action", `${url}/tarefas/${task.id}`);
    btnSave.innerHTML = `<i class='bx bx-save'></i>`;

    const btnDelete = document.createElement("button");
    btnDelete.classList.add("btn", "delete");
    btnDelete.setAttribute("data-id", task.id);
    btnDelete.setAttribute("data-action", `${url}/tarefas/${task.id}`);
    btnDelete.innerHTML = `<i class='bx bxs-trash'></i>`;

    optionDiv.append(btnEdit);
    optionDiv.append(btnSave);
    optionDiv.append(btnDelete);

    infoDiv.append(checkDiv);
    infoDiv.append(optionDiv);

    const taskDetailsDiv = document.createElement("div");
    taskDetailsDiv.classList.add("task-details");

    const i = document.createElement("i");
    i.classList.add("bx", "bx-menu");

    const details = document.createElement("span");
    details.textContent = task.description || "Descrição";

    taskDetailsDiv.append(i);
    taskDetailsDiv.append(details);

    li.classList.add("active");
    li.append(infoDiv);
    li.append(taskDetailsDiv);
    taskContainer.prepend(li);

    checkbox.addEventListener("click", () => {
        checkbox.closest(".check").classList.toggle("checked");

        const action = checkbox.getAttribute("data-action");
        const id = checkbox.getAttribute("data-id");
        const status = !Number(checkbox.getAttribute("data-status"));

        const data = {
            id: id,
            completed: status,
            _token: csrf_token,
            _method: "PUT",
        };
        if (sendModal(action, data)) {
            const li = checkbox.closest("li");
            const count = categoryContainer.parentElement.querySelector(
                ".select .selected span"
            );

            if (status) {
                count.textContent = String(Number(count.textContent) + 1);
                checkbox.setAttribute("data-status", "1");
                var container =
                    categoryContainer.parentElement.querySelectorAll(
                        ".task-container"
                    )[1];
            } else {
                count.textContent = String(Number(count.textContent) - 1);
                checkbox.setAttribute("data-status", "0");
                var container = categoryContainer.parentElement.querySelector(
                    ".task-container.first"
                );
            }
            container.prepend(li);
        }
    });

    const textOld = task.name;
    btnDelete.addEventListener("click", () => {
        const container = btnDelete.closest(".task-container");

        if (!container.classList.contains("first")) {
            const count = categoryContainer.parentElement.querySelector(
                ".select .selected span"
            );

            count.textContent = String(Number(count.textContent) - 1);
        }
        deleteTaskCategory(btnDelete, li);
    });
    btnEdit.addEventListener("click", (e) => {
        e.stopPropagation();
        enterEditMode({ text: taskText, btnEdit, btnSave });
    });
    btnSave.addEventListener("click", (e) => {
        e.stopPropagation();
        exitEditMode({ taskText, textOld, btnEdit, btnSave });
    });

    taskText.addEventListener("click", (e) => {
        e.stopPropagation();
        enterEditMode({ text: taskText, btnEdit, btnSave });
    });
    taskText.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            exitEditMode({ taskText, textOld, btnEdit, btnSave });
        }
    });

    taskText?.addEventListener("blur", () => {
        setTimeout(() => {
            exitEditMode({ taskText, textOld, btnEdit, btnSave });
        }, 100);
    });

    details.addEventListener("click", (e) => {
        e.stopPropagation();
        if (details.getAttribute("contenteditable") === "true") return;

        enterEditMode({ text: details, btnEdit, btnSave });
    });

    details.addEventListener("blur", () => {
        setTimeout(() => {
            exitEditMode({ details, btnEdit, btnSave });
        }, 100);
    });

    details.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            exitEditMode({ details, btnEdit, btnSave });
        }
    });

    li.addEventListener("click", () => {
        const isActive = li.classList.contains("active");
        document
            .querySelectorAll(".task-container li")
            .forEach((i) => i.classList.remove("active"));

        if (!isActive) li.classList.add("active");
    });
}

function addCategory(category) {
    const containerList = document.querySelector(".content .tasks-list");
    const taskItem = document.createElement("div");
    taskItem.classList.add("task-item");

    const hiddenSpan = document.createElement("span");
    hiddenSpan.id = `category-${category.id}`;
    hiddenSpan.className = "list__id";
    hiddenSpan.dataset.id = category.id;
    hiddenSpan.style.display = "none";
    taskItem.appendChild(hiddenSpan);

    const taskBackHead = document.createElement("div");
    taskBackHead.id = "task-back-head";

    const taskHead = document.createElement("div");
    taskHead.className = "task-head";

    const categoryName = document.createElement("p");
    categoryName.textContent = category.name;

    const options = document.createElement("div");
    options.className = "options";

    const iconOption = document.createElement("span");
    iconOption.className = "icon-option";
    iconOption.setAttribute("p-title", "Opções da lista");
    iconOption.textContent = "⋮";

    const categoryOptions = document.createElement("div");
    categoryOptions.className = "category-options";

    const boxOptions = document.createElement("div");
    boxOptions.className = "box-options";

    const changeName = document.createElement("span");
    changeName.className = "change-name";
    changeName.textContent = "Mudar de nome";

    const deleteDone = document.createElement("span");
    deleteDone.className = "delete-task-done";
    deleteDone.textContent = "Eliminar todas as tarefas concluidas";

    const deleteCategory = document.createElement("span");
    deleteCategory.className = "delete-category";
    deleteCategory.textContent = "Eliminar a lista";

    boxOptions.append(changeName, deleteDone, deleteCategory);
    categoryOptions.appendChild(boxOptions);
    options.append(iconOption, categoryOptions);

    taskHead.append(categoryName, options);
    taskBackHead.appendChild(taskHead);

    const addTask = document.createElement("div");
    addTask.className = "add-task";

    const iconAdd = document.createElement("i");
    iconAdd.className = "bx bx-chevron-down-circle";

    const spanAdd = document.createElement("span");
    spanAdd.textContent = "Adicionar uma tarefa";

    addTask.append(iconAdd, spanAdd);
    taskBackHead.appendChild(addTask);

    const taskContent = document.createElement("div");
    taskContent.className = "task-content";

    const noTasks = document.createElement("div");
    noTasks.className = "no-tasks";

    const img = document.createElement("img");
    img.src = url + "/images/empty-tasks-dark.svg";
    img.alt = "";

    const noTasksHead = document.createElement("div");
    noTasksHead.className = "no-tasks-head";

    const h3 = document.createElement("h3");
    h3.textContent = "Ainda não tem tarefas";

    const p = document.createElement("p");
    p.textContent = "Adicione tarefas para fazer e monitorize-as no To do List";

    noTasksHead.append(h3, p);
    noTasks.append(img, noTasksHead);

    taskItem.append(taskBackHead, taskContent, noTasks);

    containerList.append(taskItem);

    taskItem.querySelector(".add-task").addEventListener("click", () => {
        const nomeCategory = taskItem.querySelector(".task-head p").textContent;

        const select = formCreate.querySelector("select");
        for (let option of select.options) {
            if (option.text === nomeCategory) {
                select.value = option.value;
                break;
            }
        }
        formCreate.classList.add("active");
    });

    taskItem.classList.remove("clicked");
    taskItem.addEventListener("click", () => {
        document
            .querySelectorAll(".content .task-item")
            .forEach((t) => t.classList.remove("clicked"));
        taskItem.classList.add("clicked");
    });

    taskItem.querySelector(".icon-option").addEventListener("click", () => {
        const isActive = taskItem
            .querySelector(".icon-option")
            .classList.contains("active");
        document
            .querySelectorAll(".task-item .icon-option")
            .forEach((i) => i.classList.remove("active"));
        document
            .querySelectorAll(".task-item .category-options")
            .forEach((opt) => opt.classList.remove("active"));
        if (!isActive) {
            taskItem.querySelector(".icon-option").classList.add("active");
            taskItem.querySelector(".category-options").classList.add("active");
        }
    });
    updatedFormTask(category);
    updatedMenuList(category, taskItem);
}

function updatedFormTask(category) {
    const select = formCreate.querySelector("select");

    const option = document.createElement("option");
    option.value = category.id;
    option.text = category.name;

    select.append(option);
}

function updatedMenuList(category, task) {
    const li = document.createElement("li");
    li.classList.add("list__id");
    li.dataset.id = category.id;

    const div = document.createElement("div");
    const spanCheckBox = document.createElement("span");
    spanCheckBox.classList.add("checkbox");
    const categoryName = document.createElement("span");
    categoryName.classList.add("menu-item-text");
    categoryName.textContent = category.name;
    div.append(spanCheckBox, categoryName);
    const spanCounter = document.createElement("span");
    spanCounter.classList.add("counter");
    spanCounter.textContent = "0";

    li.append(div, spanCounter);

    menuDropdown.append(li);

    li.addEventListener("click", () => {
        li.classList.toggle("check");
        task.classList.toggle("hidden");

        if (task.classList.contains("hidden")) {
            setTimeout(() => {
                task.style.display = "none";
            }, 500);
        } else {
            task.style.display = "block";
        }
    });
}

function removeFormTask(id) {
    const select = formCreate.querySelector("select");

    for (let option of select.options) {
        if (option.value === id) {
            option.remove();
        }
    }
}

function removeMenuList(id) {
    const li = menuDropdown.querySelectorAll("li");

    li.forEach((l) => {
        if (l.getAttribute("data-id") == id) {
            l.remove();
        }
    });
}

async function sendModal(actionModal, dataModal) {
    const data = JSON.stringify(dataModal);

    const myHeaders = new Headers({
        Accept: "application/json",
        "Content-Type": "application/json",
    });

    const options = {
        method: "POST",
        headers: myHeaders,
        body: data,
    };

    try {
        const response = await fetch(actionModal, options);

        if (response.ok) {
            return 1;
        }

        throw new Error(`HTTP error: ${response.status}`);
    } catch (error) {
        console.error("error ao enviar:", error);
        return 0;
    }
}

function enterEditMode({ text, btnEdit, btnSave } = {}) {
    document.querySelectorAll(".task-container li").forEach((li) => {
        li.classList.remove("active");
    });

    const li = text.closest("li");

    text.setAttribute("contenteditable", "true");
    text.focus();
    li.classList.add("active");

    if (btnEdit && btnSave) {
        btnEdit.style.display = "none";
        btnSave.style.display = "flex";
    }
}
function exitEditMode({ details, taskText, textOld, btnEdit, btnSave }) {
    const action = btnSave.getAttribute("data-action");
    const id = btnSave.getAttribute("data-id");
    const csrf = csrf_token;

    const data = {
        id: id,
        _token: csrf,
        _method: "PUT",
    };

    const closeElementEdit = (element, text) => {
        if (element.textContent === "") element.textContent = text;
        element.setAttribute("contenteditable", false);
    };

    if (details) {
        data.description = details.textContent;
        closeElementEdit(details, "Details");
    }

    if (taskText) {
        data.name = taskText.textContent;
        closeElementEdit(taskText, textOld);
    }

    if (sendModal(action, data)) {
        if (btnEdit) btnEdit.style.display = "flex";
        if (btnSave) btnSave.style.display = "none";
    }
}

function deleteTaskCategory(btnDelete, father) {
    const action = btnDelete.getAttribute("data-action");
    const id = btnDelete.getAttribute("data-id");
    const csrf = csrf_token;

    const data = {
        id: id,
        _token: csrf,
        _method: "DELETE",
    };

    if (sendModal(action, data)) {
        father.remove();
    }
}


document.addEventListener("DOMContentLoaded", () => {
    const flash = document.querySelector(".ajax-response");


    if (flash && flash.classList.contains("active")) {
        setTimeout(() => {
            flash.classList.remove("active");
        }, 3000);
    }
});