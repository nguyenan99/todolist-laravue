<template>
    <div class="row todo-content" style="background-color: #a7a7e8; height: 100vh">
        <div class="col-md-6">
            <div class="todo-list not-done">
                <h1>TODOS</h1>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter content" v-model="textContent">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2" @click="addTask()" style="background-color: #28a745;
    color: white;">Add</button>
                    </div>
                </div>
                <hr>
                <ul class="list-unstyled" v-for="(todo, index) in todos" :key="todo.id">
                    <li class="ui-state-default li-items mt-1">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" aria-label="Radio button for following text input" :checked="todo.checked">
                                </div>
                            </div>
                            <input type="text" class="form-control" :class="{ 'done-task' : todo.completed }" v-model="todo.content">
                            <div class="input-group-append remove-icon">
                                <span class="input-group-text" @click="delTask(index,todo.id)">&#10060;</span>
                            </div>
                        </div>
                    </li>
                </ul>
                <hr>
                <div class="todo-footer row">
                    <div class="col-md-6">
                        <div class="form-check form-check-inline" @click="checkAll(true)">
                            &#9989;
                            <label class="form-check-label" >Check all</label>
                        </div>
                        <div class="form-check form-check-inline" @click="checkAll(false)">
                            &#10062;
                            <label class="form-check-label"  >UnCheck all</label>
                        </div>
                    </div>
                    <div class="col-md-6 save-all">
                        <div class="form-check form-check-inline save-all">
                            <button type="button" class="btn btn-success btn-sm" @click="doneAll()">DONE ALL &#10004;</button>
                        </div>
                        <div class="form-check form-check-inline save-all">
                            <button type="button" class="btn btn-dark btn-sm" @click="delAll()">DEL ALL &#10006;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from'axios'
export default {
    data : function () {
        return{
            todos:[],
            textContent: "",
            todoIds :[],

        }
    },
    created() {
        axios.get('http://127.0.0.1:8000/api/todos')
        .then(response => {
            this.todos = response.data.data
        })
    },
    methods : {
        addTask : function ()
        {
            this.todos.push(
                {
                    'content' : this.textContent,
                    'checked' : false,
                    'completed' : false
                }

            )
            axios.post('http://127.0.0.1:8000/api/todos', {
                content : this.textContent,
                checked : false,
                completed : false
            })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            this.textContent = ""

        },
        delTask : function (index,key)
        {
            if (confirm("Ban có chắc chắn xóa "))
            {
                axios.delete('http://127.0.0.1:8000/api/todos/' + key )
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                this.todos.splice(index, 1)
            }


        },
        checkAll : function (flag)
        {
            this.todos.forEach(todo => {
                todo.checked = flag
            })
        },
        doneAll : function ()
        {
            if (confirm("Bạn có chắc chắn hoàn thành tất cả ?"))
            {
                this.todos.filter(function (item)
                {
                    if (item.checked)
                    {
                        item.completed = true;
                    }
                })
            }
            this.checkAll(false)
        },
        delAll : function ()
        {
            var todoIds = []
            this.todos.filter(function (todo){
                if(todo.checked)
                {
                    todoIds.push(todo.id)
                }
            })
            console.log(todoIds)
            if (confirm("Bạn có chắc chắn hoàn thành tất cả ?"))
            {
                axios.get('http://127.0.0.1:8000/api/todos/deleteAll',{
                    ids : todoIds
                } )
                    .then((response) => {
                        console.log(response)
                    }, (error) => {
                        console.log(error);

                    })

                this.todos = this.todos.filter(function (item)
                {
                    return !item.checked
                })
            }
        }
    }
}

</script>

<!-- Thêm "scoped" giới hạn CSS bên dưới chỉ áp dụng cho component này -->
<style scoped>
.todo-content {
    display: flex;
    justify-content: center;
}

.todo-list h1 {
    margin-top: 20px;
    padding-bottom: 20px;
    text-align: center;
    font-weight: bold;
}

.todo-footer {
    background-color: #d2e8ca;
    padding: 10px 20px 15px;
}

#done-items li {
    padding: 10px 0;
    border-bottom: 1px solid #ddd;
    text-decoration: line-through;
}

.done-task {
    text-decoration: line-through;
    color: orange;
}

.form-check-inline {
    cursor: pointer;
}

.remove-icon span {
    cursor: pointer;
}

.save-all {
    float: right;
}
</style>
