// 初始化
var fileId = document.getElementById('fileId');
var rateId = document.getElementById('rateId');
var finishId = document.getElementById('finishId');
var linkId = document.getElementById('linkId');
var moduleId = document.getElementById('moduleId').value;
var cueId = document.getElementById('cueId');

//---------------------------
var file = null;
var fileMd5Value = '';
// 分片总数
var total_blob_num;
// 进程队列
var courseQueue = [];
// 分片队列
var burstQueue = [];
// 进度队列
var progressQueue = [];

var courseTimer = 0;
var progressTimer = 0;

//-----------------------------
var upload_instance = new Upload();

fileId.onchange = function () {
    //如果文件大，md5值生成较慢  md5值生成后才能上传处理，自己优化下吧
    browserMD5File(fileId.files[0].slice(0, 1000), function (err, md5) {
        fileMd5Value = md5; //如果需要刷新后也能断点，可利用cookie记录，自行完善
    });
    // 验证文件格式
    var check_ext = ''
    $.ajax({
        type: "POST",
        url: 'file.php?rec=bigfile&act=ext',
        data: {"check_filename":fileId.files[0]['name']},
        dataType: "html",
        async: false,
        success: function(html) {
            if (html) {
                cueId.innerHTML = html;
            } else {
                check_ext = true
            }
        }
    });
    
    if (check_ext) {
        // 执行上传操作
        upload_instance.addFileAndSend(fileId);
    }
    
    // 每次执行后要清空文件域
    fileId.value = '';
};

function Upload() {
    //对外方法，传入文件对象
    this.addFileAndSend = function (that) {
        restartUpload();

        var step = 1024 * 1024 * 1.8; // 分卷大小1.8M
        file = that.files[0];
        total_blob_num = Math.ceil(file.size / step);


        var start = 0;
        var end = start + step;
        for (var blob_num =1; blob_num <= total_blob_num; blob_num++) {
            burstQueue.push({
                id: blob_num,
                start: start,
                end: end
            });
            start = end;
            end = start + step;
        }

        // 启动上传队列
        courseTimer = setInterval(sendFile, 10);
        // 启动进程监控器
        progressTimer = setInterval(progressChecker, 1000);
    };

    function restartUpload() {
        clearInterval(courseTimer);
        clearInterval(progressTimer);
        burstQueue = [];
        courseQueue = [];
        progressQueue = [];

        var progress = 0 + '%';
        finishId.style.width = progress;
        rateId.innerHTML = progress;
    }

    function progressChecker() {
        var finishNum = progressQueue.length;
        var progress = (Math.min(100, (finishNum / total_blob_num) * 100)).toFixed(2) + '%';
        console.log('progress-----' + progress);
        finishId.style.width = progress;
        rateId.innerHTML = progress;
        if (progressQueue.length === total_blob_num) {
            clearInterval(progressTimer);
            clearInterval(courseTimer);
        }
    }

    //发送文件
    function sendFile() {
        // 如果队列满负荷运载，则不再起队列
        if (courseQueue.length >= 20) {
            return;
        }

        // 如果分片已经被分配完了，终止定时器
        if (burstQueue.length === 0) {
            return;
        }
        
        // 否则加入进程列表
        var burst = burstQueue.shift();
        courseQueue.push(1);

        var file_blob = file.slice(burst.start, burst.end);
        var form_data = new FormData();
        form_data.append('file', file_blob);
        form_data.append('blob_num', burst.id);
        form_data.append('total_blob_num', total_blob_num);
        form_data.append('file_md5_value', fileMd5Value);
        form_data.append('file_name', file.name);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', './file.php?rec=bigfile&module=' + moduleId, false);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                courseQueue.shift();
                progressQueue.push(1);
            }
        };

        xhr.send(form_data);

        // 回调
        var data = JSON.parse(xhr.responseText);
        
        setTimeout(function () {
             linkId.value = data.file_path;
        }, 1500);
    }
}