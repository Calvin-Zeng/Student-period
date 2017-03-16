//#include <ncurses.h>
//#include <pthread.h>
//#include<sys/types.h>
//#include<arpa/inet.h>
//#include<unistd.h>

#include <curses.h>

#include<sys/socket.h>
#include<netinet/in.h>

#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#include <pthread.h>

#define NUM_THREADS 1
#define MAXSOCKFD 10

#define PORTNUMBER 5050

	int i,x=0,y,upx=0,upy,tmpwinHeight,winHeight,upWinHeight,lowWinHeight,separator,ch,chatting=1;
	WINDOW *upWin,*lowWin,*upBox,*curwin;

	char buffer[256]="";
	int  sock;
	struct sockaddr_in server;
	struct sockaddr_in addr;
void *initializeServer(void *TCPinfo)	
{	
	int sockfd,newsockfd,is_connected[MAXSOCKFD],fd;
	
	int addr_len = sizeof(struct sockaddr_in);
	fd_set readfds;
	char recbuffer[256];
	char msg[ ] = "Welcome to server! ";
	
	/* 建立socket */
	if ((sockfd = socket(AF_INET,SOCK_STREAM,0))<0){
		perror("socket ");
		exit(1);
	}

	/* 填寫server端的sockaddr_in結構 */
	//bzero(&addr,sizeof(addr));
	addr.sin_family =AF_INET;
	addr.sin_port = htons(4000);
	addr.sin_addr.s_addr = htonl(INADDR_ANY);

	/* 連結socket */
	if(bind(sockfd,&addr,sizeof(addr))<0){
		perror("connect ");
		exit(1);
	}

	/* 等待連線 */
	if(listen(sockfd,3)<0){
		perror("listen ");
		exit(1);
	}

	/*  */
	for(fd=0;fd<MAXSOCKFD;fd++)
		is_connected[fd]=0;

	/*  */
	while(1)
	{
		FD_ZERO(&readfds);
		FD_SET(sockfd,&readfds);

		for(fd=0;fd<MAXSOCKFD;fd++)
			if(is_connected[fd])
				FD_SET(fd,&readfds);

		if(!select(MAXSOCKFD,&readfds,NULL,NULL,NULL))
			continue;

		for(fd=0;fd<MAXSOCKFD;fd++)
			if(FD_ISSET(fd,&readfds))
			{
				if(sockfd == fd)
				{
					if((newsockfd = accept (sockfd,&addr,&addr_len))<0)
					perror("accept ");
					//write(newsockfd,msg,sizeof(msg));
					is_connected[newsockfd] =1;
					//printf("cnnect from %s\n ",inet_ntoa(addr.sin_addr));
					//mvwaddstr(upWin,3,0,"cnnect from %s\n ");
				}else{ 
					bzero(recbuffer,sizeof(recbuffer));
					if(read(fd,recbuffer,sizeof(recbuffer))<=0)
					{
						//printf("connect closed.\n ");
						is_connected[fd]=0;
						close(fd);
					}else  
					{
					//winHeight = lowWinHeight;
					curwin = upWin;
					tmpwinHeight=winHeight;
					winHeight = upWinHeight;
					//getyx(upWin,upy,upx);		/* 取得工作視窗中的當前游標位置 */
					//mvwaddstr(curwin,upy,0,recbuffer);
					mvaddstr(upy, 0, recbuffer);
					if (upy == winHeight-1)	/* 若游標已在工作視窗的最底行了 */
					scroll(curwin);		/* 工作視窗中的資料向上捲動一行 */
					else ++upy;
					//mvaddstr(upy-1, 0, buffer);
					//wmove(curwin,upy,upx);
					wrefresh(curwin);		/* 該工作視窗中的改變顯示出來 */
					winHeight = tmpwinHeight;
					curwin = lowWin;
					
					
					
					//printf("%s ",buffer);
					}
					
				}// End of else 
			}  // End of if(FD_ISSET(fd,&readfds))
	} // End of while(1)


}


void *initializeClient(void *TCPinfo)	
{	
	bzero(&server,sizeof(server));
	server.sin_family=PF_INET;
	server.sin_addr.s_addr=inet_addr("127.0.0.1");
	server.sin_port=htons(4000);
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

int  main(int argc, char *argv[])
{

	struct sockaddr_in  partyTCPinfo;	/* IPv4 socket定址結構 */
	pthread_t threadClient,threadServer;
	if (argc==2)	/* 參數帶有對方IP (argv[1]) */
	partyTCPinfo.sin_addr.s_addr=inet_addr(argv[1]);
	/* else 取 server 接受連線請求時，抓到與對方通訊的 sock 來與對方通訊*/
	partyTCPinfo.sin_port=htons(PORTNUMBER);


	
	initializeCurses();			/* curses初始化 */
	pthread_create(&threadServer, NULL, initializeServer,(void *)&partyTCPinfo);
	pthread_create(&threadClient, NULL, initializeClient,(void *)&partyTCPinfo);
	//initializeServer();
	//initializeClient();			/* Client初始化 */

		
	separator=LINES*0.75;			/* 分割兩視窗，上半為3/4，下半為1/4 */
	upWinHeight=separator-1;		/* 上半視窗高 */
	lowWinHeight=LINES-separator-1;	/* 下半視窗高 */

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
			
			sock=socket(PF_INET,SOCK_STREAM,0); //產生socket
			connect(sock,(struct sockaddr *)&server,sizeof(server)); //與server連線
			write(sock,buffer,sizeof(buffer));
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

