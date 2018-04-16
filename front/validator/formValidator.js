import reqwest from 'reqwest';

function displayErrors(node, id) {
    if (Object.prototype.hasOwnProperty.call(node, 'children')) {
        Object.keys(node.children).forEach((key) => {
            displayErrors(node.children[key], `${id}_${key}`);
        });
    }
    let htmlErrors = dom(`#${id}_errors`);
    if (Object.prototype.hasOwnProperty.call(node, 'errors')) {
        if (!htmlErrors) {
            const htmlInput = dom(`#${id}`);
            if (!htmlInput) {
                return;
            }
            htmlInput.parentNode.insertAdjacentHTML(
                'beforeend',
                `<ul id="${id}_errors" class="form form__errors"></ul>`
            );
            htmlErrors = dom(`#${id}_errors`);
        }
        htmlErrors.innerHTML = '';
        node.errors.forEach((value) => {
            htmlErrors.insertAdjacentHTML('beforeend', `<li class="form__error">${value}</li>`);
        });
    } else if (htmlErrors) {
        htmlErrors.parentNode.removeChild(htmlErrors);
    }
}

export default (formType, form) => {
    formType = encodeURI(formType);
    form.addEventListener('change', () => {
        const url = `/api/form/validate/${formType}`;

        const formData = new FormData(form);
        formData.toRemove = [];
        formData.forEach((value, key, $this) => {
            if (!value) {
                $this.toRemove.push(key);
            }
        });
        for (let x = 0; x < formData.toRemove.length; x += 1) {
            formData.delete(formData.toRemove[x]);
        }

        reqwest({
            url,
            method: 'post',
            data: formData,
            processData: false,
            success(resp) {
                displayErrors(resp.form, form.name);
            },
        });
    });
};
