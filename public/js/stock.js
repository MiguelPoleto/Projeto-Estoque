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

                const productInfoDiv = modal.querySelector('.product-info');

                if (form) {
                    form.reset();
                    form.classList.remove("was-validated");
                }

                if (productInfoDiv) {
                    productInfoDiv.style.display = 'none';
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
});

function updateProductInfo(productId, modalPrefix) {
    const productInfoDiv = document.getElementById(`${modalPrefix}_product_info`);
    const amountInfo = productInfoDiv.querySelector('.product-amount');
    const priceInput = document.getElementById(`${modalPrefix}_product_price`);
    const minimumInfo = productInfoDiv.querySelector('.product-minimum');
    const totalPriceInfo = productInfoDiv.querySelector('.product-total-price');
    const amountInput = document.getElementById(`${modalPrefix}_amount`);

    if (productId) {
        fetch(`/estoque/produto/${productId}`, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
            .then((response) => response.json())
            .then(data => {
                if (data.success) {
                    amountInfo.innerText = data.product.amount || '';
                    priceInput.value = data.product.price ? parseFloat(data.product.price).toFixed(2) : '';
                    minimumInfo.innerText = data.product.minimum_stock || '';
                    totalPriceInfo.innerText = data.product.total_price ? parseFloat(data.product.total_price).toFixed(2) : '';
                    productInfoDiv.style.display = 'block';

                    if (modalPrefix === 'sell') {
                        const maxAmount = data.product.amount - data.product.minimum_stock;
                        amountInput.max = maxAmount;
                        amountInput.setAttribute('max', maxAmount);
                    }

                } else {
                    alert('Erro ao buscar informações do produto.');
                }
            })
            .catch(error => {
                console.error('Erro na requisição AJAX:', error);
                alert('Erro ao buscar informações do produto.');
            });
    } else {
        productInfoDiv.style.display = 'none';
    }
}

document.getElementById("product_id_buy").addEventListener("change", (e) => {
    updateProductInfo(e.target.value, 'buy');
});

document.getElementById("product_id_sell").addEventListener("change", (e) => {
    updateProductInfo(e.target.value, 'sell');
});


function calculateTotalForSale() {
    const buyAmount = parseFloat(document.getElementById('buy_amount').value) || 0;
    const buyPrice = parseFloat(document.getElementById('buy_product_price').value) || 0;
    const sellPrice = parseFloat(document.getElementById('sell_product_price').value) || 0;
    const sellAmount = parseFloat(document.getElementById('sell_amount').value) || 0;

    if (buyAmount > 0) {
        const total = buyAmount * buyPrice;
        document.getElementById('buy_total_price').value = total.toFixed(2);
    } else if (sellAmount > 0) {
        const total = sellAmount * sellPrice;
        document.getElementById('sell_total_price').value = total.toFixed(2);
    }
}
document.getElementById('buy_amount').addEventListener('input', calculateTotalForSale);
document.getElementById('buy_product_price').addEventListener('input', calculateTotalForSale);
document.getElementById('sell_product_price').addEventListener('input', calculateTotalForSale);
document.getElementById('sell_amount').addEventListener('input', calculateTotalForSale);