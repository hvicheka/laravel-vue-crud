<template>
    <div class="container-fluid">
        <div class="pb-4 mb-4">
            <h3 class="display-6 float-left">Student List</h3>
            <button class="btn btn-sm btn-success float-right" @click="clearData" data-toggle="modal" data-target="#students" >
                New Student
            </button>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in results.data" :key="row.id">
                    <td>{{ row.name }}</td>
                    <td>{{ row.email }}</td>
                    <td>{{ row.phone }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" @click="(edit = true),(add = false),editStudent(row.id)" data-toggle="modal" data-target="#students">
                            edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" @click="getID(row.id)" data-toggle="modal" data-target="#msg">
                            delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <pagination :data="results" @pagination-change-page="getResults" ></pagination>
        <!-- The Modal -->
        <div class="modal" id="students">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ modal_title }}</h4>
                        <button type="button" @click="(add = true),(edit = false),clearData" class="close" data-dismiss="modal" >
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" v-model="name" class="form-control" id="name"/>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" v-model="email" class="form-control" id="email" />
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" v-model="phone" class="form-control" id="phone" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-danger" @click="(add = true),(edit = false),clearData" data-dismiss="modal" >
                            Close
                        </button>
                        <button v-if="add" class="btn btn-outline-success" @click="saveStudent" >
                            Save
                        </button>
                        <button v-if="edit" class="btn btn-outline-success" @click="updateStudent" >
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="msg">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Student</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure, you want to delete?
                        <input type="hidden" v-model="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close </button>
                        <button class="btn btn-outline-success" @click="doDelete()" > Delete </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            add: true,
            edit: false,
            modal_title: "Create Student",
            results: {},
            id: "",
            name: "",
            email: "",
            phone: ""
        };
    },
    mounted() {
        // Fetch initial results
        this.getResults();
    },
    methods: {
        saveStudent() {
            axios.post("/student/create", {
                    name: this.name,
                    email: this.email,
                    phone: this.phone
                })
                .then(res => {
                    this.clearData();
                    this.getResults();
                });
        },
        editStudent(id) {
            this.modal_title = "Edit Student";
            axios.get("/student/edit/" + id).then(res => {
                this.id = res.data.id;
                this.name = res.data.name;
                this.email = res.data.email;
                this.phone = res.data.phone;
            });
        },
        updateStudent() {
            axios.put("/student/update/", {
                    id: this.id,
                    name: this.name,
                    email: this.email,
                    phone: this.phone
                })
                .then(res => {
                    this.clearData();
                    this.getResults();
                });
        },
        getID(id){
          this.id = id
        },
        doDelete(){
          this.deleteStudent(this.id);
        },
        deleteStudent(id){
          axios.delete('student/delete/' + id).then((res) => {
            this.getResults()
          });
        },
        clearData() {
            this.id = "",
            this.name = "";
            this.email = "";
            this.phone = "";
        },
        getResults(page = 1) {
            axios.get("student/?page=" + page).then(response => {
                this.results = response.data;
            });
        }
    }
};
</script>
