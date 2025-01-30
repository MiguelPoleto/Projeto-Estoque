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

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-info.btn-sm').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const productIdDetail = this.getAttribute('data-product-id');

            fetch(`/estoque/detalhes/${productIdDetail}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        populateDetailsModal(data.product);
                        bootstrap.Modal.getOrCreateInstance(document.getElementById('detailProductModal')).show();
                    } else {
                        alert(data.message || 'Erro ao buscar informações do produto.');
                    }
                })
                .catch(error => {
                    console.error('Erro: ', error);
                    alert('Erro ao carregar os detalhes do produto.');
                });
        });
    });
});

function populateDetailsModal(product) {
    try {
        document.getElementById('detail-product-id').textContent = product.product_id;
        document.getElementById('detail-name').textContent = product.name;

        const categoryMap = {
            'eletronic': 'Eletrônicos',
            'furniture': 'Móveis',
            'raw_material': 'Vestuário',
            'others': 'Outros'
        };
        document.getElementById('detail-category').textContent = categoryMap[product.category];

        const unitMap = {
            'pcs': 'Peças',
            'kg': 'Quilogramas',
            'g': 'Gramas',
            'l': 'Litros',
            'ml': 'Mililitros',
            'm': 'Metros',
            'cm': 'Centímetros',
            'un': 'Unidades'
        };
        document.getElementById('detail-unit').textContent = unitMap[product.unit];

        document.getElementById('detail-amount').textContent = product.amount;
        document.getElementById('detail-price').textContent = parseFloat(product.price).toFixed(2);

        document.getElementById('detail-description').textContent = product.description || 'Não informado';
        document.getElementById('detail-sku').textContent = product.sku || 'Não informado';
        document.getElementById('detail-barcode').textContent = product.barcode || 'Não informado';
        document.getElementById('detail-supplier').textContent = product.supplier || 'Não informado';
        document.getElementById('detail-supplier-contact').textContent = product.supplier_contact || 'Não informado';
        document.getElementById('detail-brand').textContent = product.brand || 'Não informado';
        document.getElementById('detail-location').textContent = product.location || 'Não informado';
        document.getElementById('detail-minimum-stock').textContent = product.minimum_stock || 'Não informado';
        document.getElementById('detail-status').textContent = product.is_active == 1 ? 'Ativo' : 'Inativo';
    } catch (error) {
        console.error('Erro ao preencher modal:', error);
        alert('Erro ao exibir detalhes do produto.');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-primary.btn-sm').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const productId = this.closest('tr').querySelector('td:first-child').textContent;
            openEditModal(productId);
        });
    });
});

function openEditModal(productId) {
    fetch(`/estoque/produto/${productId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateEditModal(data.product);
                const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                editModal.show();
            } else {
                Swal.fire({
                    title: 'Erro!',
                    text: data.message || 'Erro ao carregar informações do produto.',
                    icon: 'error',
                    confirmButtonText: 'Fechar'
                });
            }
        })
        .catch(error => {
            console.error('Erro ao carregar produto:', error);
            Swal.fire({
                title: 'Erro!',
                text: 'Erro ao carregar informações do produto.',
                icon: 'error',
                confirmButtonText: 'Fechar'
            });
        });
}

function populateEditModal(product) {
    document.getElementById('edit-product-id').value = product.product_id;
    document.getElementById('edit-name').value = product.name;
    document.getElementById('edit-category').value = product.category;
    document.getElementById('edit-unit').value = product.unit;
    document.getElementById('edit-price').value = parseFloat(product.price).toFixed(2);
    document.getElementById('edit-description').value = product.description || '';
    document.getElementById('edit-sku').value = product.sku || '';
    document.getElementById('edit-barcode').value = product.barcode || '';
    document.getElementById('edit-supplier').value = product.supplier || '';
    document.getElementById('edit-supplier-contact').value = product.supplier_contact || '';
    document.getElementById('edit-brand').value = product.brand || '';
    document.getElementById('edit-location').value = product.location || '';
    document.getElementById('edit-minimum-stock').value = product.minimum_stock || '1';
    document.getElementById('edit-status').value = product.is_active != null ? product.is_active.toString() : '1';
}

document.querySelector('#editProductModal form').addEventListener('submit', function (e) {
    e.preventDefault();

    if (!validateForm(this)) {
        return;
    }

    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Produto atualizado com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'Fechar'
                }).then(() => {
                    bootstrap.Modal.getInstance(document.getElementById('editProductModal')).hide();
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Erro!',
                    text: data.message || 'Erro ao atualizar o produto.',
                    icon: 'error',
                    confirmButtonText: 'Fechar'
                });
            }
        })
        .catch(error => {
            console.error('Erro ao atualizar produto:', error);
            Swal.fire({
                title: 'Erro!',
                text: 'Erro ao atualizar o produto.',
                icon: 'error',
                confirmButtonText: 'Fechar'
            });
        });
});

document.getElementById('edit-price').addEventListener('change', function () {
    this.value = parseFloat(this.value).toFixed(2);
});

document.getElementById('editProductModal').addEventListener('hidden.bs.modal', function () {
    this.querySelector('form').reset();
    this.querySelector('form').classList.remove('was-validated');
});