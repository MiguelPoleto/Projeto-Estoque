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

    // Evitar a duplicação de eventos
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

        //Fechar os modals corretamente
        const modals = document.querySelectorAll(".modal");

        modals.forEach((modal) => {
            modal.addEventListener("hidden.bs.modal", () => {
                if (form) {
                    form.reset();
                    form.classList.remove("was-validated");
                }
            });
        });
    });

    const addProductSaveBtn = document.getElementById("addProductModal")?.querySelector("#saveProduct");
    const buyProductSaveBtn = document.getElementById("buyProductModal")?.querySelector("#saveBuyProduct");
    const sellProductSaveBtn = document.getElementById("sellProductModal")?.querySelector("#saveSellProduct");

    if (addProductSaveBtn) {
        addProductSaveBtn.addEventListener("click", () => {
            handleModalSave("addProductModal");
        });
    }

    if (buyProductSaveBtn) {
        buyProductSaveBtn.addEventListener("click", () => {
            handleModalSave("buyProductModal");
        });
    }

    if (sellProductSaveBtn) {
        sellProductSaveBtn.addEventListener("click", () => {
            handleModalSave("sellProductModal");
        });
    }


    // Responsividade dinâmica de compra / venda
    const productSelect = document.getElementById("product_id");
    const amountInfo = document.getElementById("product_amount");
    const priceInfo = document.getElementById("product_price");
    const categoryInfo = document.getElementById("product_category");

    productSelect.addEventListener("change", () => {
        const selectedoption = this.options[this.selectedIndex];

        if (selectedoption) {
            const amount = selectedoption.getAttribute("data-amount");
            const price = selectedoption.getAttribute("data-price");
            const category = selectedoption.getAttribute("data-category");

            amountInfo.value = amount ? amount : "";
            priceInfo.value = price ? parseFloat(price).toFixed(2) : "";
            categoryInfo.value = category ? category : "";
        } else {
            amountInfo.value = "-";
            priceInfo.value = "-";
            categoryInfo.value = "-";
        }
    });
});


function calculateTotalForSale() {
    const buyAmount = parseFloat(document.getElementById('buy_amount').value) || 0;
    const buyPrice = parseFloat(document.getElementById('buy_price').value) || 0;
    const sellAmount = parseFloat(document.getElementById('sell_amount').value) || 0;
    const sellPrice = parseFloat(document.getElementById('sell_price').value) || 0;
    
    if (buyAmount > 0) {
        const total = buyAmount * buyPrice;
        document.getElementById('buy_total_price').value = total.toFixed(2);
    } else if (sellAmount > 0) {
        const total = sellAmount * sellPrice;
        document.getElementById('sell_total_price').value = total.toFixed(2);
    }
}
document.getElementById('buy_amount').addEventListener('input', calculateTotalForSale);
document.getElementById('buy_price').addEventListener('input', calculateTotalForSale);
document.getElementById('sell_amount').addEventListener('input', calculateTotalForSale);
document.getElementById('sell_price').addEventListener('input', calculateTotalForSale);