Public Class result
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        Dim sds As New SqlDataSource
        Dim sqlstr As String
        Dim day As Integer
        Dim result As DataView
        Dim dv As DataView


        Select Case Session("day")
            Case "Monday"
                day = 1
            Case "Tuesday"
                day = 2
            Case "Wednesday"
                day = 3
            Case "Thursday"
                day = 4
            Case "Friday"
                day = 5
            Case "Saturday"
                day = 6
            Case "Sunday"
                day = 7
        End Select

        sds.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
        If Session("return") = 1 Then
            Label2.Text = Session("returnstartstation") & "→" & Session("returnendstation")
            Label3.Text = Session("returndate") 'DateTime.Now.ToString("yyyy/MM/dd")
            sqlstr = "SELECT a.train_id as 車次,a.timeline_time as 發車時間,b.timeline_time as 抵達時間,a.timeline_time as 暫存 FROM timeline a,timeline b,trains WHERE trains.train_id = a.train_id AND b.train_id = a.train_id AND trains.train_direction = '" & Session("direction") & "' AND a.timeline_station = '" & Session("returnstartstation") & "' AND b.timeline_station = '" & Session("returnendstation") & "' AND trains.d" & day & " =1 AND a.timeline_time >='" & Session("returnstationtime") & "' ORDER BY a.timeline_station ASC"
        Else
            Label2.Text = Session("startstation") & "→" & Session("endstation")
            Label3.Text = Session("date") 'DateTime.Now.ToString("yyyy/MM/dd")
            sds.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
            sqlstr = "SELECT a.train_id as 車次,a.timeline_time as 發車時間,b.timeline_time as 抵達時間,a.timeline_time as 暫存 FROM timeline a,timeline b,trains WHERE trains.train_id = a.train_id AND b.train_id = a.train_id AND trains.train_direction = '" & Session("direction") & "' AND a.timeline_station = '" & Session("startstation") & "' AND b.timeline_station = '" & Session("endstation") & "' AND trains.d" & day & " =1 AND a.timeline_time >='" & Session("stationtime") & "'"
        End If
        sds.SelectCommand = sqlstr
        result = sds.Select(New DataSourceSelectArguments())


        dv = result
        Dim i As Integer
        Dim st As Integer
        Dim et As Integer
        Dim stm As Integer
        Dim etm As Integer

        For i = 0 To dv.Table.Rows.Count - 1 Step 1
            st = CInt(Left(dv.Table.Rows(i)(1), 2)) * 60
            stm = CInt(Right(dv.Table.Rows(i)(1), 2)) + st
            et = CInt(Left(dv.Table.Rows(i)(2), 2)) * 60
            etm = CInt(Right(dv.Table.Rows(i)(2), 2)) + et
            etm = etm - stm
            et = etm \ 60
            etm = etm Mod 60
            dv.Table.Rows(i)(3) = CStr(et).PadLeft(2) & "時" & CStr(etm).PadLeft(2, "0") & "分"
        Next

        Me.GridView1.DataSource = result
        Me.GridView1.DataBind()

        If Session("return") = 1 Then
            For i = 0 To Me.GridView1.Rows.Count - 1 Step 1
                If Session("returndate") & " " & Me.GridView1.Rows(i).Cells(2).Text < DateTime.Now.ToString("yyyy/MM/dd HH:mm") Then
                    Me.GridView1.Rows(i).Cells(5).Text = ""
                End If
            Next
        Else
            For i = 0 To Me.GridView1.Rows.Count - 1 Step 1
                If Session("date") & " " & Me.GridView1.Rows(i).Cells(2).Text < DateTime.Now.ToString("yyyy/MM/dd HH:mm") Then
                    Me.GridView1.Rows(i).Cells(5).Text = ""
                End If
            Next
        End If






        '----------------------------------------------------
        'sds.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
        'sqlstr = "SELECT a.timeline_time as 發車時間,b.timeline_time as 抵達時間 FROM timeline a,timeline b,trains WHERE trains.train_id = a.train_id AND b.train_id = a.train_id AND trains.train_direction = '" & Session("direction") & "' AND a.timeline_station = '" & Session("startstation") & "' AND b.timeline_station = '" & Session("endstation") & "' AND trains.d" & day & " =1 AND a.timeline_time >='" & Session("stationtime") & "'"
        'sds.SelectCommand = sqlstr
        'dv = sds.Select(New DataSourceSelectArguments())
        'Me.GridView1.DataSource = sds.Select(New DataSourceSelectArguments())
        'Me.GridView1.DataBind()

        'sds.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
        'sqlstr = "SELECT a.timeline_time as 發車時間 FROM timeline a,timeline b,trains WHERE trains.train_id = a.train_id AND b.train_id = a.train_id AND trains.train_direction = '" & Session("direction") & "' AND a.timeline_station = '" & Session("startstation") & "' AND b.timeline_station = '" & Session("endstation") & "' AND trains.d" & day & " =1 AND a.timeline_time >='" & Session("stationtime") & "'"
        'sds.SelectCommand = sqlstr
        'Me.GridView2.DataSource = sds.Select(New DataSourceSelectArguments())
        'Me.GridView2.DataBind()
        'sds.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
        'sqlstr = "SELECT b.timeline_time as 抵達時間 FROM timeline a,timeline b,trains WHERE trains.train_id = a.train_id AND b.train_id = a.train_id AND trains.train_direction = '" & Session("direction") & "' AND a.timeline_station = '" & Session("startstation") & "' AND b.timeline_station = '" & Session("endstation") & "' AND trains.d" & day & " =1 AND a.timeline_time >='" & Session("stationtime") & "'"
        'sds.SelectCommand = sqlstr
        'Me.GridView4.DataSource = sds.Select(New DataSourceSelectArguments())
        'Me.GridView4.DataBind()
        'sds.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
        'sqlstr = "SELECT a.train_id as 車次,b.timeline_time as 抵達時間 FROM timeline a,timeline b,trains WHERE trains.train_id = a.train_id AND b.train_id = a.train_id AND trains.train_direction = '" & Session("direction") & "' AND a.timeline_station = '" & Session("startstation") & "' AND b.timeline_station = '" & Session("endstation") & "' AND trains.d" & day & " =1 AND a.timeline_time >='" & Session("stationtime") & "'"
        'sds.SelectCommand = sqlstr
        'Me.GridView5.DataSource = sds.Select(New DataSourceSelectArguments())
        'Me.GridView5.DataBind()


    End Sub

    Private Sub GridView1_RowCommand(ByVal sender As Object, ByVal e As System.Web.UI.WebControls.GridViewCommandEventArgs) Handles GridView1.RowCommand
        If e.CommandName = "book" Then
            If Session("return") = 1 Then
                Session("returnnumber") = GridView1.Rows(e.CommandArgument).Cells(1).Text
                Session("returnstime") = GridView1.Rows(e.CommandArgument).Cells(2).Text
                Session("returnetime") = GridView1.Rows(e.CommandArgument).Cells(4).Text
                Response.Redirect("booking.aspx")
            Else
                Session("number") = GridView1.Rows(e.CommandArgument).Cells(1).Text
                Session("stime") = GridView1.Rows(e.CommandArgument).Cells(2).Text
                Session("etime") = GridView1.Rows(e.CommandArgument).Cells(4).Text
                Response.Redirect("booking.aspx")
            End If

        End If

    End Sub
End Class