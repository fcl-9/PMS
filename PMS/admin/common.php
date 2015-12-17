        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                <img alt="Brand" src="..\images\drawing2.png">
              </a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <p class="navbar-text" >Bem-Vindo(a), John Smith!</p>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#adicionar"><span class="glyphicon glyphicon-plus"></span></i> Adicionar <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="adicionar" class="collapse">
                            <li>
                                <a href="admin-add-reserva.php">Reserva</a>
                                <a href="admin-add-funcionario.php">Funcionário</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#alterar"><span class="glyphicon glyphicon-refresh"></span></i> Alterar <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="alterar" class="collapse">
                            <li>
                                <a href="admin-altera-reserva.php">Reserva</a>
                                 <a href="admin-altera-funcioanrio.php">Funcionário</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                       <a href="javascript:;" data-toggle="collapse" data-target="#remover"><span class="glyphicon glyphicon-remove"></span></i> Remover <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="remover" class="collapse">
                            <li>
                                <a href="#">Reserva</a>
                                 <a href="#">Funcionário</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="forms.html"><i class="fa fa-fw fa-power-off"></i> Terminar Sessão</a>
                    </li>
               
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

