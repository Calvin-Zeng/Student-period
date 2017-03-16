Public Class bookingdetails
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load


        Dim sds As New SqlDataSource
        Dim sqlstr As String
        sds.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
        sqlstr = "SELECT code As 交易代碼, ordertime AS 訂票時間,start_station AS 起站 ,end_station AS 到達 FROM orderinfo WHERE id='" & Session("id") & "'"
        sds.SelectCommand = sqlstr
        Me.GridView1.DataSource = sds.Select(New DataSourceSelectArguments())
        Me.GridView1.DataBind()



    End Sub

    Private Sub GridView1_RowCommand(ByVal sender As Object, ByVal e As System.Web.UI.WebControls.GridViewCommandEventArgs) Handles GridView1.RowCommand
        If e.CommandName = "Delete" Then

            Session("idcode") = GridView1.Rows(e.CommandArgument).Cells(3).Text.ToString
            Session("rownumber") = e.CommandArgument

            Dim sds As New SqlDataSource
            Dim sqlstr As String
            sds.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
            sqlstr = "Delete FROM orderinfo WHERE id='" & Session("id") & "' AND code= '" & Session("idcode") & "'"
            sds.DeleteCommand = sqlstr
            sds.Delete()
            sqlstr = "Delete FROM ticketprinum WHERE code= '" & Session("idcode") & "'"
            sds.DeleteCommand = sqlstr
            sds.Delete()


            sds.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
            sqlstr = "SELECT code As 交易代碼, ordertime AS 訂票時間,start_station AS 起站 ,end_station AS 到達 FROM orderinfo WHERE id='" & Session("id") & "'"
            sds.SelectCommand = sqlstr
            Me.GridView1.DataSource = sds.Select(New DataSourceSelectArguments())
            Me.GridView1.DataBind()
        End If

    End Sub

    Private Sub GridView1_RowDeleting(ByVal sender As Object, ByVal e As System.Web.UI.WebControls.GridViewDeleteEventArgs) Handles GridView1.RowDeleting

    End Sub

    Protected Sub Button1_Click(ByVal sender As Object, ByVal e As EventArgs) Handles Button1.Click
        Me.Session.Clear()
        Response.Redirect("default.aspx")
    End Sub
End Class