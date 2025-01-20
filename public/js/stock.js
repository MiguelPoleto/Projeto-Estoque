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

        const options = {
            method: method,
            body: formData,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        };

        fetch(url, options)
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

            // Exclusão de um produto
            if (form.action.includes("estoque/deletar")) {
                Swal.fire({
                    title: "Tem certeza?",
                    text: "Você não poderá reverter isso!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sim, deletar!",
                    cancelButtonText: "Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(form.action, {
                            method: form.method,
                            body: new FormData(form),
                            headers: { "X-Requested-With": "XMLHttpRequest" },
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                Swal.fire("Deletado!", "O produto foi deletado.", "success").then(() => {
                                    document.location.reload();
                                });
                            } else {
                                Swal.fire("Erro!", data.message || "Erro ao deletar o produto.", "error");
                            }
                        })
                        .catch((error) => {
                            console.error("Erro na requisição AJAX:", error);
                            Swal.fire("Erro!", "Ocorreu um erro inesperado.", "error");
                        });
                    }
                });
            }
        });
    });

    const addProductSaveBtn = document.getElementById("addProductModal")?.querySelector("#saveProduct");
    const saleProductSaveBtn = document.getElementById("saleProductModal")?.querySelector("#saveSaleProduct");

    if (addProductSaveBtn) {
        addProductSaveBtn.addEventListener("click", () => {
            handleModalSave("addProductModal");
        });
    }

    if (saleProductSaveBtn) {
        saleProductSaveBtn.addEventListener("click", () => {
            handleModalSave("saleProductModal");
        });
    }
});


function calculateTotalForSale() {
    const amount = parseFloat(document.getElementById('sale_amount').value) || 0;
    const price = parseFloat(document.getElementById('sale_price').value) || 0;
    const total = amount * price;
    document.getElementById('sale_total_price').value = total.toFixed(2);
}
document.getElementById('sale_amount').addEventListener('input', calculateTotalForSale);
document.getElementById('sale_price').addEventListener('input', calculateTotalForSale);