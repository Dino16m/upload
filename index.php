
<!DOCTYPE html>
<html>
  <head>
  	<script type="text/javascript" src="vue.js"></script>
    <script type="text/javascript" src="axios.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
    <link href="bootstrap.css" rel="stylesheet">
  	<script type="text/javascript" src="bootstrap.min.js"></script>

<title></title>
  <body>
    <div id="app" class="container w-100 text-center">
    <input type="file" id="files" ref="files" multiple v-on:change="handleFileUpload()">

    
     <div class=" d-flex justify-content-md-center flex-wrap flex-row w-100  rounded primary bg-secondary">
       <div class="border border-secondary" v-for="(file, key) in files">
         <div class="row align-self-center ">
              <span class='p-2 flex-fill bg-primary'>{{file.name}}</span><button class=" btn btn-danger" v-on:click="remove(key, file.name)"> remove</button><br>
             <label class=" p-2 flex-fill badge badge-secondary">HD</label> <input type="radio" v-bind:name='name[key]'  v-on:change="handleQuality(file.name, key)"  v-model='quality[key]' value='HD'>
            <label class="p-2badge flex-fill badge-secondary">Not HD</label> <input type="radio" v-bind:name='name[key]'  v-on:change="handleQuality(file.name, key)"  v-model='quality[key]' value='nHD'><br>
            <label class="p-2 badge flex-fill badge-primary">the quality is:{{quality[key]}}</label><br>
      </div>
          <span class="d-block bg-secondary badge badge-primary flex-row">-------</span>
        </div>
     
     <div class="d-flex justify-content-md-center ">
    <button class="d-flex flex-md-column bg-light w-40" v-on:click=submit()> Submit <button>
    <button class="d-flex flex-md-column bg-light w-40" v-on:click="addfiles()">addfiles</button>
    </div>
    <div class="progress bg-success ">
       <div class="progress-bar progress-bar-striped text-center" role="progressbar" v-bind:style="{width: width}" v-bind:aria-valuenow="uploadValue" aria-valuemin="0" aria-valuemax="100"> {{width}}</div>
    </div>
      <div class="badge badge-success">{{status}}</div>
    </div>
    
    <script>
    Vue.use(axios);
    new Vue({
      el: '#app',
      data(){
        return{
          files: [],
          status: 'we are yet to recive an update',
          emptyfile: [],
          quality:[],
          qualities:[],
          name:[],
          width: '1%',
          uploadValue:0
  
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
        handleQuality(name, key){
          for(var i = 0; i<this.qualities.length; i++){
	          let iteration = this.qualities[i];
	          if( name==iteration.name){
	            this.qualities.splice(i,1);
	            break;
	          }
	        }
	        let quality = this.quality;
          let qualityObject = {'name': name.replace(/\./g,'_'), 'quality':quality[key]};
          this.qualities.push(qualityObject);
          console.log(this.qualities)
	      },
	
        submit(){
          let formData = new FormData();
          for(var i=0; i<this.files.length; i++){
            let file = this.files[i];
            let quality = this.qualities[i];
            let finalName = quality.name+'_quality';
            let finalQuality =quality.quality;
            formData.append('files['+ i + ']',file);
            formData.append(finalName, finalQuality);
            console.log(finalQuality+' POWER');
          }
            axios.post('uploader.php', formData,{
              headers:{ 'Content-Type': 'multipart/form-data'} ,
                onUploadProgress: function(progressEvent){
                  this.uploadValue=parseInt(Math.round((progressEvent.loaded*100)/progressEvent.total));
                  let value=this.uploadValue;
                  console.log(value+'me');
                  this.width= (value.toString()+'%');
                }.bind(this)
              
            }).then(function(response){
              this.status=response.data;
              }.bind(this)
            ).catch(function(){
              this.status= 'unfortunately not uploaded';
            }.bind(this));
          
        },
        addfiles(){
          this.$refs.files.click();
          for(var i = 0; i<this.files.length; i++){
            this.name[i]=i;
          }
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