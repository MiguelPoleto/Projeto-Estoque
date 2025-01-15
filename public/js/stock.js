function calculateTotalForSale() {
    const amount = parseFloat(document.getElementById('sale_amount').value) || 0;
    const price = parseFloat(document.getElementById('sale_price').value) || 0;
    const total = amount * price;
    document.getElementById('sale_total_price').value = total.toFixed(2);
}
document.getElementById('sale_amount').addEventListener('input', calculateTotalForSale);
document.getElementById('sale_price').addEventListener('input', calculateTotalForSale);


function validateForm(form) {
    const isValid = form.checkValidity();
    if (!isValid) {
        form.classList.add('was-validated');
    }
    return isValid;
}

document.addEventListener("DOMContentLoaded", () => {
    const handleModalSave = (modalId) => {
        const modal = document.getElementById(modalId);
        const form = modal.querySelector("form");

        if (!validateForm(form)) {
            console.error("Formulário inválido.");
            return;
        }

        // Cria uma requisição AJAX para enviar o formulário
        const formData = new FormData(form);
        const url = form.getAttribute("action");
        const method = form.getAttribute("method");

        fetch(url, {
            method: method,
            body: formData,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire({
                        title: "Sucesso!",
                        text: "Ação concluída com sucesso.",
                        icon: "success",
                        confirmButtonText: "Fechar",
                    }).then(() => {
                        modal.querySelector("form").reset();
                        modal.classList.remove("show");
                        document.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: "Erro!",
                        text: data.message || "Erro ao processar os dados.",
                        icon: "error",
                        confirmButtonText: "Fechar",
                    });
                }
            })
            .catch((error) => {
                console.error("Erro na requisição AJAX:", error);
                Swal.fire({
                    title: "Erro!",
                    text: "Ocorreu um erro inesperado.",
                    icon: "error",
                    confirmButtonText: "Fechar",
                });
            });
    };

    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", (event) => {
            event.preventDefault();
        });
    });

    const addProductSaveBtn = document.getElementById("addProductModal")?.querySelector("#saveProduct");
    const editProductSaveBtn = document.getElementById("editProductModal")?.querySelector("#saveSaleProduct");

    if (addProductSaveBtn) {
        addProductSaveBtn.addEventListener("click", () => {
            handleModalSave("addProductModal");
        });
    }

    if (editProductSaveBtn) {
        editProductSaveBtn.addEventListener("click", () => {
            handleModalSave("editProductModal");
        });
    }
});
