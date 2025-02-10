<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagina Inicial</title>
    <style>
        ul {
            margin-bottom: 20px; /* Aumenta o espaço entre os itens da lista */
        }
        .form-container {
            margin-bottom: 30px; /* Aumenta o espaço entre os formulários */
        }
        form {
            display: inline-block;
            margin-bottom: 20px; /* Aumenta o espaço entre os formulários */
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>

</head>
<body>
    <h1>Bem-vindo à Empresa de Formação ESTCursosDigit </h1>
    <div class="container">
        <span class="texto" style="font-size: px;">Formação em Competências Digitais</span>
    </div>
    <h2>Informações sobre a Empresa</h2>
    <ul>
        <li>Localização: Avenida do Empresário</li> 
        <li>6000-767 Castelo Branco</li>
        <li>Horários de Funcionamento: 8:00 às 22:00 de Segunda a Sexta-feira <br>Sábados das 9:00 às 13:00</li>
        <li>Cursos: </li>

        
        
<!-- codigo jsp -->
    <%@ page pageEncoding="UTF-8" %>
    <%@ include file="../basedados/basedados.h" %>

    <%
        PreparedStatement ps=null;
        ResultSet rs=null;
        
        if(conn!=null){
            String sql="SELECT * FROM cursos";
            ps=conn.prepareStatement(sql);
            rs=ps.executeQuery();

        %>
    <table>
        <tr>
            <th>Nome do Curso</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Numero de vagas Restantes</th>
        </tr>
        <%
            while(rs.next()) {
        %>
            <tr>
                <td><%=rs.getString("nome_curso") %></td>
                <td><%=rs.getString("descricao") %></td>
                <td><%=rs.getString("preco") %></td>
                <td><%=rs.getString("vagas_disponiveis") %></td>
            </tr>
        <%
            }
        %>
    </table>
    <%
        }else{
            out.println("Erro na conexão à base de dados");
        }
        ps.close();
        rs.close(); 
        conn.close();
        
        
        

    %>

    

<!-- FIM codigo jsp -->

    </ul>
    <div class="form-container">
        <h2>Login</h2>
        <form action="login.jsp" method="POST"> 
            User_name: <input type="text" name="user_name" style="margin-bottom: 10px;"><br>
            Password: <input type="password" name="password" style="margin-bottom: 10px;"><br>
            <input type="submit" name="Login">
        </form>
    </div>

    <div class="form-container">
        <h2>Registo</h2>
        <form action="registo.jsp" method="post">
            <input type="hidden" name="isDocente" value="false"> <!-- forma para saber se é docente -->
            Nome: <input type="text" name="nome" style="margin-bottom: 10px;"><br>      
            Último nome: <input type="text" name="ultimo_nome"style="margin-bottom: 10px;"><br>      
            E-mail: <input type="text" name="e_mail"style="margin-bottom: 10px;"><br>
            User_name: <input type="text" name="user_name"style="margin-bottom: 10px;"><br>
            Password: <input type="password" name="password"style="margin-bottom: 10px;"><br>
            Perfil:
            <select name="perfil" style="margin-bottom: 10px;">
                <option value="aluno">Aluno</option>
                <option value="docente">Docente</option>
                <option value="admin">Administrador</option>
            </select><br>
            <input type="submit" value="Registar-se">
        </form>
    </div>
</body>
</html>