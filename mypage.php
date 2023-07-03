    <?php
    include('./top.php');
    ?>
    </header>
    <!-- End Header Area -->
<?php
    include('./dbconn.php');
    $dbconn = dbconn();
    $id=$_SESSION['id'];
    $searchSql="SELECT email from userTbl where id='$id'";
    $result=mysqli_query($dbconn,$searchSql);
    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        if($row!=null)
        {
            $email= $row['email'];
        }
    }
?>
    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 custom-padding-right">
                        <!-- Start Small Banner -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Area -->


 

    <div class="container">
        <div class="input-form-backgroud row">
            <div class="input-form col-md-9 mx-auto">
                <h4 class="mb-3"><br><br>마이페이지</h4>
                <form class="validation-form" name="Registerfrm" action="edit-mypage.php" method="post" >
                    

                    <div class="mb-3">
                        <label for="name">이름</label>
                        <input type="text" class="form-control" id="name"  value="<?php echo $_SESSION['name']; ?>" name="name" required disabled>
                        <div class="invalid-feedback">
                            이름을 입력해주세요.
                        </div>
                    </div>
                    
                    
        
                    <div class="mb-3">
                        <label for="password">현재 비밀번호<span style="color: #ff0000;">*</span><span class="text-muted">&nbsp;</span></label>
                        <input type="password" class="form-control" id="password" placeholder="현재 비밀번호를 입력해주세요." name="password" required>
                    </div>
                  
                    <div class="mb-3">
                        <label for="password">새 비밀번호<span class="text-muted">&nbsp;</span></label>
                        <input type="password" class="form-control" id="Newpassword" placeholder="8~30자리/새 비밀번호를 입력해주세요." name="Newpassword">
                    </div>
        
                    <div class="mb-3">
                        <label for="password">비밀번호 2차 확인 <span class="text-muted">&nbsp;</span></label>
                        <input type="password" class="form-control" id="Newpassword_check" placeholder="비밀번호를 입력해주세요. (2차 확인)" name="Newpassword_check" >
                        <div id="errorMessage" style="color: red; display:none;">비밀번호가 일치하지 않습니다.</div>
                    </div>
    
                    <div class="mb-3">
                        <label for="email">이메일</label>
                        <input type="email" class="form-control" id="email" placeholder="" name="email" value=" <?php 
                            echo $email;
                        ?>">
                        <div class="invalid-feedback">
                            이메일을 입력해주세요.
                        </div>
                    </div>
    
                    
                  
                    <div class="mb-4"></div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">수정 완료</button>
                </form>
                <br><br><br>
            </div>
        </div>
    </div>

    <?php
    include('./btm.php');
    ?>
</body>
<script>
        Newpassword_check.onblur = function() {
            if(Newpassword.value!=Newpassword_check.value)
            {
                errorMessage.style.display='block';
                
            }else {
                errorMessage.style.display='none';
            }
        };
    </script>
</html>