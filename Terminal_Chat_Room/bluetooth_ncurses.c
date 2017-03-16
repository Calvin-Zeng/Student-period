#include <stdio.h>
#include <unistd.h>
#include <sys/socket.h>
#include <bluetooth/bluetooth.h>
#include <bluetooth/rfcomm.h>
#include <bluetooth/hci.h>
#include <bluetooth/hci_lib.h>

#include <stdlib.h>
#include <string.h>
#include <pthread.h>

#include <curses.h>

#define NUM_THREADS 1
#define MAXSOCKFD 10

#define PORTNUMBER 5050

	int i,x=0,y,upx=0,upy,tmpwinHeight,winHeight,upWinHeight,lowWinHeight,separator,ch,chatting=1,dy,dx=0;
	WINDOW *upWin,*lowWin,*upBox,*curwin,*pop;

	char buffer[256]="";
	int  sock;
	
    struct address {
        char address[18];
    } address;

	struct sockaddr_rc server = { 0 };
	struct sockaddr_rc addr = { 0 };
	struct sockaddr_rc rem_addr = { 0 };
	struct sockaddr_rc loc_addr = { 0 };
	struct address stu;

void *initializeServer(void *TCPinfo)	
{	
 /* 用struct sockaddr_rc來建立RFCOMM連線 */
    //struct sockaddr_rc loc_addr = { 0 }, rem_addr = { 0 };
    char buf[1024] = { 0 };
    int s, client, bytes_read;
    socklen_t opt = sizeof(addr);
	
    /* allocate socket (藉系統呼叫socket()來配置socket) */
    s = socket(AF_BLUETOOTH, SOCK_STREAM, BTPROTO_RFCOMM);
    /* internet programming的socket()系統呼叫為 */
    /* socket(AF_INET, SOCK_STREAM, IPPROTO_TCP) */

    /* 設定 struct sockaddr_rc 中的成員值 */
    // bind socket to port 1 of the first available 
    // local bluetooth adapter
	addr.rc_family = AF_BLUETOOTH;
    addr.rc_bdaddr = *BDADDR_ANY;
    addr.rc_channel = (uint8_t) 1; 

	
	while(1){

    bind(s, (struct sockaddr *)&addr, sizeof(addr));

    // put socket into listening mode
    listen(s, 1); // 聆聽(socket,埠號)

    // accept one connection
    client = accept(s, (struct sockaddr *)&rem_addr, &opt);

    ba2str( &rem_addr.rc_bdaddr, buf );
    //fprintf(stderr, "accepted connection from %s\n", buf);
    memset(buf, 0, sizeof(buf));

    // read data from the client
    bytes_read = read(client, buf, sizeof(buf));
    if( bytes_read > 0 ) {
        //printf("received [%s]\n", buf);
					//winHeight = lowWinHeight;
					curwin = upWin;
					tmpwinHeight=winHeight;
					winHeight = upWinHeight;
					//getyx(upWin,upy,upx);		/* 取得工作視窗中的當前游標位置 */
					//mvwaddstr(curwin,upy,0,recbuffer);
					mvaddstr(upy, 0, buf);
					if (upy == winHeight-1)	/* 若游標已在工作視窗的最底行了 */
					scroll(curwin);		/* 工作視窗中的資料向上捲動一行 */
					else ++upy;
					//mvaddstr(upy-1, 0, buffer);
					//wmove(curwin,upy,upx);
					winHeight = tmpwinHeight;
					wrefresh(curwin);		/* 該工作視窗中的改變顯示出來 */
					curwin = lowWin;

    }
 	if(buf[0]=='0')
	break; 
	// close connection
}
    close(client);
    close(s);
}

void *initializeClient(void *address)	
{	
    int s;
    s = socket(AF_BLUETOOTH,SOCK_STREAM,BTPROTO_RFCOMM);
    //set connection parameters (who to connect to)
    server.rc_family = AF_BLUETOOTH;
    server.rc_channel = (uint8_t) 1;
	//  str2ba( dest, &addr.rc_bdaddr );
	str2ba(stu.address, &server.rc_bdaddr );
}
void searchdevice(){
 	inquiry_info *ii = NULL;
    int max_rsp, num_rsp;
    int dev_id, sock, len, flags;
    int i;
    char addr[19] = { 0 };
    char name[248] = { 0 };
 
    dev_id = hci_get_route(NULL);
    sock = hci_open_dev( dev_id );
    if (dev_id < 0 || sock < 0) {
        perror("opening socket");
        exit(1);
    }

    len  = 8;
    max_rsp = 255;
    flags = IREQ_CACHE_FLUSH;
    ii = (inquiry_info*)malloc(max_rsp * sizeof(inquiry_info));
    
    num_rsp = hci_inquiry(dev_id, len, max_rsp, NULL, &ii, flags);
    if( num_rsp < 0 ) perror("hci_inquiry");

    for (i = 0; i < num_rsp; i++) {
        ba2str(&(ii+i)->bdaddr, addr);
        memset(name, 0, sizeof(name));
        if (hci_read_remote_name(sock, &(ii+i)->bdaddr,sizeof(name),name, 0)< 0)
        strcpy(name, "[unknown]");
		//strcat(addr, name);

		mvwaddstr(pop,4+i,2,i);
		mvwaddstr(pop,4+i,5,addr);
		mvwaddstr(pop,4+i,22,name);
        //printf("%s  %s\n", addr, name);
		
		
    }
    free( ii );
    close( sock );
 
}
void initializeCurses()	/* curses初始化 */
{
	initscr();     
	cbreak;          
	noecho();      
	nonl();
	intrflush(stdscr,FALSE);
	keypad(stdscr,TRUE); 
}
int main(int argc, char *argv[])
{
    int s, status;
	struct sockaddr_rc partyMACinfo;	/* IPv4 socket定址結構 */
	//struct Student_Perosnal_Data stu;
	pthread_t threadClient,threadServer;
	
	
 	if (argc==2)	/* 參數帶有對方IP (argv[1]) */
	strcpy(stu.address, argv[1]);
	//str2ba(argv[1], &partyMACinfo.rc_bdaddr); 
	


	
	initializeCurses();			/* curses初始化 */
	pthread_create(&threadServer, NULL, initializeServer,(void *)&partyMACinfo);
	pthread_create(&threadClient, NULL, initializeClient,(void *)&address);
	
	separator=LINES*0.75;			/* 分割兩視窗，上半為3/4，下半為1/4 */
	upWinHeight=separator-1;		/* 上半視窗高 */
	lowWinHeight=LINES-separator-1;	/* 下半視窗高 */

	 pop=newwin(12,60,LINES/3-3, COLS/3-15);/* 建立一個新視窗, 其中LINES,COLS */
     box(pop,'|','-');                     /* 為 curses 內定值, 即螢幕行/列數*/

	
	for (i=0;i<COLS;++i)              	/* 畫兩個視窗間的分割線 */
		mvaddch(separator,i,'=');

	upWin=newwin(separator-1,COLS-2,0,0); /* 設定上半視窗 */
	lowWin=newwin(LINES-separator,COLS-2,separator+1,0); /* 設定下半視窗 */

	scrollok(upWin,TRUE);   		/* 開啟上半視窗捲動功能 */
	scrollok(lowWin,TRUE);  		/* 開啟下半視窗捲動功能 */

	refresh();

	curwin = lowWin;
	winHeight = lowWinHeight;
	
	do{
		ch=getch();		/* 取得鍵入的一個字元 */

		switch(ch)		/* 判斷鍵入的是特殊字元還是一般英數字元，然後決定處理方式 */
		{
		/* 暫不處理↑↓←→(上下左右)鍵的功能。*/
		/* 若要啟用這些功能，則要使用二維的buffer來保留工作視窗上當前顯示的所有資料， */
		/* 並隨時要記下每步移動的游標位置，而且要正確反應修改資料的結果。*/
		case KEY_UP: --y;             /* "↑"鍵被按下  */
		break;
		case KEY_DOWN: ++y;           /* "↓"鍵被按下  */
		break;
		case KEY_RIGHT: ++x;          /* "→"鍵被按下  */
		break;
		case KEY_LEFT: --x;           /* "←"鍵被按下  */
		break;

		case 13 :                     /* ENTER 鍵被按下  */
			/* 在此插入呼叫送出簡訊的socket clent函式(送出一行訊息)... */
			getyx(curwin,y,x);		/* 取得工作視窗中的當前游標位置 */
			if (y == winHeight-1)	/* 若游標已在工作視窗的最底行了 */
				scroll(curwin);		/* 工作視窗中的資料向上捲動一行 */
			else ++y;			/* 否則游標跳到下一行 */
			//buffer[x]='\0';
			x=0;				/* 游標回到一行的開頭處 */
			//mvaddstr(y-1, 0, buffer);
			s = socket(AF_BLUETOOTH,SOCK_STREAM,BTPROTO_RFCOMM);
			status = connect(s, (struct sockaddr *)&server, sizeof(server));
			if( status == 0 ) {
			status = write(s, buffer, strlen(buffer));
			}
			if( status < 0 ) perror("uh oh");
			close(s);
			memset(buffer,0,256);
		break;

		case 263 :			/* BACKSPACE 鍵被按下 */
			getyx(curwin,y,x);	/* 要 delete 一個字元,先取得目前游標位置 */
			if (x > 0)		/* 游標不在開頭處才需要處理 */
			{
				wmove(curwin,y,--x);	/* 然後退回到前一個字元 */
				waddch(curwin,' ');	/* 之後再於該處以空白字元取代之 */
			}
			/* 注意: 儲存送出訊息的buffer(字元陣列)中的資料也要記得修改... */
		break;

		case 27 : chatting=0;		/* [ESC] 鍵被按下，結束程式。 */
		break;
		case '\t':              /* 按 [TAB] 鍵 呼叫另一視窗   */
			mvwaddstr(pop,1,8,"Choose Target");
			searchdevice();
			mvwaddstr(pop,10,2,"Press anykey to continue..");
			touchwin(pop);        /* wrefresh() 前需 touchwin() */
			wrefresh(pop);
			getch();              /* 按任意鍵關閉視窗 */
			touchwin(stdscr);
		break;
		default:			/* 鍵入的字元為一般英數字元 */
			waddch(curwin,ch);	/* 將鍵入的字元回應在螢幕上 */
			buffer[x++]=ch;
			/* 注意:此處要將鍵入的字元寫入送出訊息的buffer中的正確位置，*/
			/*     等待按下Enter鍵時送出... */
		break;
		} // End of switch

		wmove(curwin,y,x);	/* 在工作視窗中移游標到第y列第x行的位置 */
		wrefresh(curwin);		/* 該工作視窗中的改變顯示出來 */

	} while(chatting);  // End of do loop
	
	
	endwin();				/* Curses結束 */
	
	return 0;
	pthread_exit(NULL);

}

