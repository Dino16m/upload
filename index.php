
<!DOCTYPE html>
<html>
  <head>
  	<script type="text/javascript" src="vue.js"></script>
    <script type="text/javascript" src="axios.js"></script>
<title></title>
  <body>
    <div id="app">
    <input type="file" id="files" ref="files" multiple v-on:change="handleFileUpload()">
    <button v-on:click=submit()> Submit <button>
      
    <button v-on:click="addfiles()">addfiles</button> <hr>
     <div class="display">
       <div v-for="(file, key) in files">{{file.name}}
      HD: <input type="radio" v-bind:name='name' v-on: change="handleQuality(file.name)"  v-model='quality' value='HD'><br>
      NOT HD: <input type="radio" v-bind:name='name' v-model='quality' v-on: change="handleQuality(file.name)" value='nHD'><br>	
      Quality: {{qualitiez(file.name)}}
       <span class="remove" v-on:click="remove(key, file.name)"> remove</span> </div>
     </div>
      <div class="status">{{status}}</div>
    </div>
    
    <script>
    Vue.use(axios);
    new Vue({
      el: '#app',
      data(){
        return{
          files: [],
          status: '',
          emptyfile: [],
          quality:'',
          qualities:[],
          name:'0'
  
        }
      },
      methods: {
        handleFileUpload(){
          let uploads = this.$refs.files.files;
          for(var i = 0; i< uploads.length; i++){
            this.files.push(uploads[i]);
          } },
        remove(key, name){
          this.files.splice(key, 1);
          for(var i = 0; i<this.qualities.length; i++){
	          let iteration = this.qualities[i];
	          if( name==iteration.name){
	            this.qualities.splice(i,1);
	          }
        }},
        qualitiez(name){
          for(var i = 0; i<this.qualities.length; i++){
	          let iteration = this.qualities[i];
	          if (name==iteration.name){
	            return iteration.quality;
	          }
	          return "no quality for this one";
          }
        },
        handleQuality(name){
          for(var i = 0; i<this.qualities.length; i++){
	          let iteration = this.qualities[i];
	          if( name==iteration.name){
	            this.qualities.splice(i,1);
	            break;
	          }
	        }
          let qualityObject = {'name': name, 'quality':this.quality};
          this.qualities.push(qualityObject);
          this.quality='';
	      },
	
        submit(){
          let formData = new FormData();
          for(var i=0; i<this.files.length; i++){
            let file = this.files[i];
            let quality = this.qualities[i];
            let finalName = quality.name+'_quality';
            finalName.replace(/ /g, '');
            let finalQuality =quality.quality;
            formData.append('files['+ i + ']',file);
            formData.append(finalName, finalQuality);
            console.log(finalQuality+' POWER');
          }
            axios.post('uploader.php', formData,{
              headers:{ 'Content-Type': 'multipart/form-data'}
            }).then(function(response){
              console.log(response);
              this.files = []; }
            ).catch(function(){
              this.status= 'unfortunately not uploaded';
            });
          
        },
        addfiles(){
          this.$refs.files.click();
          this.name= this.name + '1';
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