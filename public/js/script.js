const csrf_token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

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

taskItem.forEach((task, index) => {
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
            deleteTask(btnDelete);
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
    });

    task.querySelector(".change-name").addEventListener("click", () => {
        const nameCategory = task.querySelector(".task-head p").textContent;
        formCreateCategory.querySelector(".input-box input").value =
            nameCategory;
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

    task.querySelector(".delete-category").addEventListener("click", () => {
        formEliminate("Desejas eliminar a lista?", "", "Cancelar", "Eliminar");
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
    leavingFormTask.classList.remove("active");
    inputTask.value = "";
    textAreaTask.value = "";
    formCreate.classList.remove("active");
});

selectDropdow.addEventListener("click", () => {
    caretDropdown.classList.toggle("rotate");
    menuDropdown.classList.toggle("active");
});

optionsDropdown.forEach((option) => {
    option.addEventListener("click", () => {
        option.classList.toggle("check");
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
    btn2 = "Rejeitar"
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

    form.classList.add("active");
}

document.querySelectorAll('form:not([data-send="false"])').forEach((form) => {
    form.addEventListener("submit", async function (e) {
        e.preventDefault();
        const flash = document.querySelector(".ajax-response");
        const message = flash.querySelector(".ajax-response__message");
        const parent = form.closest(".active");
        const formData = new FormData(form);
        if (!formData.get("description"))
            formData.set("description", "Descrição");
        const action = this.getAttribute("action");
        const method = this.getAttribute("method").toUpperCase();

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
            if (data.task) addTask(data.task);

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
    const url = window.location.origin;

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
            const count = categoryContainer.parentElement.querySelector(".select .selected span");

            count.textContent = String(Number(count.textContent) - 1);
        }
        deleteTask(btnDelete);
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

function deleteTask(btnDelete) {
    const action = btnDelete.getAttribute("data-action");
    const id = btnDelete.getAttribute("data-id");
    const csrf = csrf_token;

    const data = {
        id: id,
        _token: csrf,
        _method: "DELETE",
    };
    if (sendModal(action, data)) {
        const liTask = btnDelete.closest("li");
        liTask.remove();
    }
}
