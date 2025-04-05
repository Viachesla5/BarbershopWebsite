document.addEventListener('DOMContentLoaded', function() {
    const uploadBtn = document.getElementById('uploadBtn');
    const fileInput = document.getElementById('profilePic');
    const uploadMsg = document.getElementById('uploadMsg');
  
    uploadBtn.addEventListener('click', function() {
      uploadMsg.textContent = "";
  
      if (!fileInput.files || fileInput.files.length === 0) {
        uploadMsg.textContent = "Please select a file to upload.";
        uploadMsg.classList.remove('text-red-600');
        uploadMsg.classList.add('text-green-600');
        return;
      }
  
      const file = fileInput.files[0];
      const formData = new FormData();
      formData.append('profilePic', file);
  
      fetch('/profile/uploadPicture', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        
        return response.text().then(text => {
          try {
            return JSON.parse(text);
          } catch (e) {
            console.error("Response was not valid JSON:", text);
            throw new Error("Invalid JSON");
          }
        });
      })
      .then(data => {
        // data is now the parsed JSON
        if (data.success) {
          uploadMsg.textContent = data.message;
          uploadMsg.classList.remove('text-red-600');
          uploadMsg.classList.add('text-green-600');
          
          // Update the <img> src for immediate preview
          const existingImg = document.querySelector('img[alt="Profile Picture"]');
          if (existingImg) {
            existingImg.src = data.filePath;
          }
        } else {
          uploadMsg.textContent = data.message;
          uploadMsg.classList.remove('text-green-600');
          uploadMsg.classList.add('text-red-600');
        }
      })
      .catch(err => {
        console.error(err);
        uploadMsg.textContent = "An error occurred during the upload.";
        uploadMsg.classList.remove('text-green-600');
        uploadMsg.classList.add('text-red-600');
      });
    });
  });  