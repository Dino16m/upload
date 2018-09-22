<!DOCTYPE html>
<html>
  <head>
<title></title>
  <body>
    <div id="app">
    <input type="file" id="files" ref="files" multiple v-on:change="handleFileUpload()">
    <button v-on:click=submit()> Submit <button>
    
    <button v-on:click="addfiles()">addfiles</button> <hr>
     <div class="display">
       <div v-for="(file, key) in files">{{file.name}} <span class="remove" v-on:click="remove(key)"> remove</span> </div>
     </div>
      <div class="status">{{status}}</div>
    </div>
    <script type="text/javascript" src="vue.js"></script>
    <script type="text/javascript" src="axios.js"></script>
    <script>
    Vue.use(axios);
    new Vue({
      el: '#app',
      data(){
        return{
          files: [],
          status: ''
        }
      },
      methods: {
        handleFileUpload(){
          let uploads = this.$refs.files.files;
          for(var i = 0; i< uploads.length; i++){
            this.files.push(uploads[i]);
          } },
        remove(key){
          this.files.splice(key, 1);
        },
        submit(){
          let formData = new FormData();
          for(var i=0; i<this.files.length; i++){
            let file = this.files[i];
            formData.append('files['+ i + ']',JSON.stringify( file));
          }
            axios.post('uploader.php', formData,{
              headers:{ 'Content-Type': 'multipart/form-data'}
            }).then(function(response){
              console.log(response), this.files='' }
            ).catch(function(){
              this.status= 'unfortunately not uploaded'
            });
          
        },
        addfiles(){
          this.$refs.files.click();
        }
      }
    })
    </script>
    <style>
      input[type="file"]{
        position: absolute;
        top: -500px;
      }
    </style>
  </body>
  </head>
</html>