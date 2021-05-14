<template>
    <div class="bg-secondary p-5">
        <h2>List of Tasks</h2>

        <form @submit.prevent="addTodo" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title" v-model="todo.title">
            </div>
            <div class="form-group">
                <textarea class="form-control" placeholder="Body" v-model="todo.body"></textarea>
            </div>
            <button type="submit" class="btn btn-dark btn-block">Save</button>
            <button @click="clearForm()" class="btn btn-danger btn-block">Cancel</button>
        </form>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchTodos(pagination.prev_page_url)">Previous</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchTodos(pagination.next_page_url)">Next</a></li>
            </ul>
        </nav>

        <div class="card card-body mb-2" v-for="todo in todos" v-bind:key="todo.id">
            <h3>{{ todo.title }}</h3>
            <p>{{ todo.body }}</p>
            <hr>
            <div class="container">
                <div class="row justify-content-between">
                    <button @click="editTodo(todo)" class="col-4 btn btn-warning">Edit</button>
                    <button @click="deleteTodo(todo.id)" class="col-4 btn btn-danger">Delete</button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

export default {
    data() {
        return {
            todos: [],
            todo: {
                id: '',
                title: '',
                body: ''
            },
            todo_id: '',
            pagination: {},
            edit: false,
            loading: false
        };
    },

    created() {
        this.fetchTodos('/api/todos');
    },

    methods: {
        fetchTodos(page_url) {
            this.loding = true;
            axios.get(page_url).then(({data}) => {
                this.todos = data.data;
                this.makePagination(data.meta, data.links);
            })
                .catch(err => console.log(err))
                .finally(() => {
                    this.loding = false;
                })
        },
        makePagination(meta, links) {
            const {current_page, last_page} = meta
            this.pagination = {
                current_page,
                last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            };
        },
        deleteTodo(id) {
            if (confirm('Are You Sure?')) {
                axios.delete(`api/todo/${id}`).then(res => {
                    this.$toast.warning('Task deleted!');
                    this.fetchTodos('/api/todos');
                })
                    .catch(err => console.log(err));
            }
        },
        addTodo() {
            if (!this.edit) {
                axios.post('api/todo', this.todo).then(() => {
                    this.clearForm();
                    this.$toast.open('Task added!');
                    this.fetchTodos('/api/todos');
                })
                    .catch(err => console.log(err));
            } else {
                axios.put('api/todo', this.todo).then(() => {
                    this.clearForm();
                    this.$toast.open('Task updated!');
                    this.fetchTodos('/api/todos');
                })
                    .catch(err => console.log(err));
            }
        },
        editTodo(todo) {
            this.edit = true;
            this.todo.id = todo.id;
            this.todo.title = todo.title;
            this.todo.body = todo.body;
        },
        clearForm() {
            this.edit = false;
            this.todo.id = null;
            this.todo.title = '';
            this.todo.body = '';
        }
    }
}

</script>
