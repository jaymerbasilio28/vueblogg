<template>
    <div>
        <div class="container">
            <h1 class="text-center text-black">Vue Blog</h1>
            <div class="row">
                <div class="col shadow-lg p-3 bg-primary rounded">
                    <h4 class="text-black text-center ">Blog list  
                        <button type="button" class="btn btn-success pull-right " @click="openModal">add new blog post</button>
                    </h4>
                </div>
            </div>
            
            <div class="col shadow-lg p-3 mb-5 bg-white rounded">
                <div class="col">
                    <div class="col" v-for="(blog, index) in blogs">
                        <div class="shadow-lg">
                            <h2 class="text-center">{{ blog.title }}</h2>
                            <p class="text-center">{{ blog.content }}</p>
                            <div class="col text-center">
                                <button type="button" class="btn btn-primary text-center mb-3" @click="edit(index)">Edit</button>
                                <button type=button class="btn btn-danger text-center mb-3" @click="destroy(blog.id)">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade pt-5 text-center" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center bg-primary">
                        <h5 class="modal-title mt-5" id="exampleModalLabel">New Blog</h5>
                        <button type="button" class="close mt-5" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <label>Title</label>
                        <br>
                        <input type="text" class="form-control" v-model="new_blog.title" placeholder="Title" fil    >
                        <br>
                        <label>Content</label>
                        <br>
                        <textarea class="form-control" v-model="new_blog.content" placeholder="content"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">close</button>
                        <button type="button" class="btn btn-success" @click="save">Save</button>
                    </div>
                    </div>
                </div>
            </div>

              <div class="modal fade pt-5 text-center" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center bg-primary">
                        <h5 class="modal-title mt-5" id="exampleModalLabel">Edit Blog</h5>
                        <button type="button" class="close mt-5" data-dismiss="modal" aria-label="Close" @click="closeEditModal">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <label>Title</label>
                        <br>
                        <input type="text" class="form-control" v-model="new_blog.title" placeholder="Title" fil    >
                        <br>
                        <label>Content</label>
                        <br>
                        <textarea class="form-control" v-model="new_blog.content" placeholder="content"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeEditModal">Close</button>
                        <button type="button" class="btn btn-success" @click="update">Save</button>
                    </div>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                new_blog:{
                    title:null,
                    content:null
                },
                    blogs:[],
                    currentlyEditing: null,
                    isModalVisible: false,
                    edit_blog:{
                        id: null,
                        title: null,
                        content:null
                    }
                }

        },
        mounted() {
            var __this = this;
            $('#exampleModal').on('hidden.bs.modal', function(){
               __this.clearNewBlog();       
           })
            $('#editModal').on('hidden.bs.modal', function(){
               __this.clearNewBlog();      
           })
           __this.loadBlogs();
           
        },
        methods:{
            loadBlogs(){
                axios.get('/blog')
                .then((res) =>{
                    this.blogs = res.data.blogs;
                })  
                .catch((e)=> {
                    console.error(e);
                })
                .finally(()=>{
                    
                })
            },
            save(){
                axios.post('/blog', this.new_blog)
                .then((res) => {
                   this.loadBlogs();
                })  
                .catch((e) => {
                    console.error(e);
                })
                .finally(() => {
                    $('#exampleModal').modal('toggle');
                })
            },
            edit(index){
                this.edit_blog.id = this.blogs[index].id;
                this.edit_blog.title = this.blogs[index].title;
                this.edit_blog.content = this.blogs[index].content;
                $('#editModal').modal('show');
            },
            update(){
                axios.put('/blog/'+this.edit_blog.id,{
                    title: this.edit_blog.title,
                    content: this.edit_blog.content
                })
                .then((res) => {
                   this.loadBlogs();
                })  
                .catch((e) => {
                    console.error(e);
                })
                .finally(() => {
                    $('#editModal').modal('toggle');
                })
            },
             destroy(id){
                axios.delete('/blog/'+ id)
                .then((res) =>{
                    this.loadBlogs();
                })  
                .catch ((e)=>{
                console.error(e);
                })
            },
            openModal(){
                $('#exampleModal').modal('show');
            },
            closeModal() {              
                $('#exampleModal').modal('hide');
            },
            closeEditModal() {              
                $('#editModal').modal('hide');
            },
            clearNewBlog(){
                this.new_blog.title = null;
                this.new_blog.content = null;
                this.edit_blog.id = null;
                this.edit_blog.title = null;
                this.edit_blog.content = null;
            },

        }
    }
</script>
