<template>
    <div class="container mt-5">
        <Header :auth="auth" :csrfToken="csrfToken" />

        <button class="btn btn-primary mb-3" @click="goHome">Назад</button>

        <div class="row mb-4">
            <div class="col-md-6">
                <form @submit.prevent="filterByMonth">
                    <div class="input-group">
                        <input v-model="selectedMonth" type="month" class="form-control" placeholder="Выберите месяц">
                        <button type="submit" class="btn btn-primary">Фильтровать</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">Доход:</h5>
                            <span class="fw-bold text-success">{{ income }} руб.</span>
                        </div>
                        <div>
                            <h5 class="mb-0">Расход:</h5>
                            <span class="fw-bold text-danger">{{ expenses }} руб.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <button class="btn btn-success" @click="openModal('add')">
                    <i class="bi bi-plus-lg"></i> Добавить транзакцию
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered shadow-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Категория</th>
                            <th>Сумма</th>
                            <th>Дата</th>
                            <th>Описание</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="transaction in transactions" :key="transaction.id">
                            <td>{{ transaction.category.name }}</td>
                            <td>{{ transaction.amount }} руб.</td>
                            <td>{{ transaction.transaction_date }}</td>
                            <td>{{ transaction.description }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm me-2" @click="openModal('edit', transaction)">
                                    <i class="bi bi-pencil"></i> Редактировать
                                </button>
                                <button class="btn btn-danger btn-sm" @click="deleteTransaction(transaction.id)">
                                    <i class="bi bi-trash"></i> Удалить
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transactionModalLabel">{{ modalTitle }}</h5>
                        <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitTransaction">
                            <div class="mb-3">
                                <label for="category" class="form-label">Категория</label>
                                <select v-model="formTransaction.category_id" class="form-select" id="category">
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Сумма</label>
                                <input v-model="formTransaction.amount" type="number" step="0.01" class="form-control" id="amount">
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Дата транзакции</label>
                                <input v-model="formTransaction.transaction_date" type="date" class="form-control" id="date">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <textarea v-model="formTransaction.description" class="form-control" id="description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ modalButton }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Header from '@/Components/Header.vue';
import * as bootstrap from 'bootstrap';
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        auth: Object,
        csrfToken: String,
        transactions: Array,
        income: Number,
        expenses: Number,
        categories: Array
    },
    data() {
        return {
            selectedMonth: '',
            formTransaction: {
                id: null,
                category_id: '',
                amount: '',
                transaction_date: '',
                description: ''
            },
            modal: null,
            modalTitle: '',
            modalButton: ''
        };
    },
    methods: {
        goHome() {
            this.$inertia.get('/');
        },
        filterByMonth() {
            this.$inertia.get(route('transactions'), {
                month: this.selectedMonth
            });
        },
        openModal(action, transaction = null) {
            if (action === 'add') {
                this.modalTitle = 'Добавить транзакцию';
                this.modalButton = 'Добавить';
                this.formTransaction = { category_id: '', amount: '', transaction_date: '', description: '' };
            } else if (action === 'edit') {
                this.modalTitle = 'Редактировать транзакцию';
                this.modalButton = 'Сохранить изменения';
                this.formTransaction = { ...transaction };
            }

            const modalEl = document.getElementById('transactionModal');
            this.modal = new bootstrap.Modal(modalEl);
            this.modal.show();
        },
        closeModal() {
            if (this.modal) {
                this.modal.hide();
            }
        },
        submitTransaction() {
            let promise;

            if (this.formTransaction.id) {
                promise = Inertia.put(route('transactions.update', this.formTransaction.id), this.formTransaction);
            } else {
                promise = Inertia.post(route('transactions.store'), this.formTransaction);
            }

            promise.then(() => {
                this.updateData();
                this.closeModal();
            }).catch((error) => {
                console.error('Ошибка при сохранении транзакции:', error);
            });
        },
        deleteTransaction(id) {
            this.$inertia.delete(route('transactions.destroy', id))
                .then(() => {
                    this.updateData();
                });
        },
        updateData() {
            this.$inertia.get(route('transactions'), {
                month: this.selectedMonth
            });
        }
    },
    components: {
        Header
    }
}
</script>
