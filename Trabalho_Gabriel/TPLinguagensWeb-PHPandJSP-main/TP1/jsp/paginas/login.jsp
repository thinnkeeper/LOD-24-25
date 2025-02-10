
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>

</body>
</html>

<%@ include file="../basedados/basedados.h" %>
<%@page pageEncoding = "UTF-8"%>
<%
    

    PreparedStatement ps=null;
    ResultSet rs=null;

    //verifica se essas variaveis foram preenchidas  se sim inicializa-as
    if (conn != null && request.getParameter("user_name") != null && request.getParameter("password") != null) {
        String user_name = request.getParameter("user_name");
        String password = request.getParameter("password");

        //query para capturar as informacoes do utilzador que está a fazer login
        String sql= "SELECT * FROM utilizadores WHERE user_name = ? AND password = MD5(?)";
        ps = conn.prepareStatement(sql);
        ps.setString(1, user_name);
        ps.setString(2, password);


        rs = ps.executeQuery();

        if (rs.next()) {
            int autenticado = rs.getBoolean("autenticado") ? 1 : 0;
            if (autenticado == 1) {
                String perfil = rs.getString("perfil");
                int id_utilizador = rs.getInt("id_utilizador");
                
                session.setAttribute("user_name", user_name);
                session.setAttribute("perfil", perfil);
                session.setAttribute("id", id_utilizador);

                
                out.println("Login bem-sucedido. Redirecionando para a sua página.");
                
                switch (perfil) {
                    case "aluno":
                        out.println(user_name);
                        response.setHeader("Refresh", "3;url=menu_aluno.jsp");
                        break;
                    case "docente":
                        response.setHeader("Refresh", "3;url=menu_docente.jsp");
                        break;
                    case "admin":
                        response.setHeader("Refresh", "3;url=menu_admin.jsp");
                        break;
                }
            } else {
                out.println("Ainda não foi validado ! Por favor, aguarde.");
                response.setHeader("Refresh", "3;url=index.jsp");
            }
        } else {
            out.println("Credênciais inválidas");
            response.setHeader("Refresh", "3;url=index.jsp");
        }
    } else {
        out.println("Erro na conexão à base de dados");
        response.setHeader("Refresh", "3;url=index.jsp");
    }
    
    rs.close();
    ps.close();
    conn.close();
%>
