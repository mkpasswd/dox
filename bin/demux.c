#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#define BS 20

int showtype=0;
int o=0;
int e=0;
int verbose=0;
unsigned char* fname=NULL;
unsigned char* foutname=NULL;

FILE *fin,*fout;

u_int8_t header[8];

char *tprefix(int t) {
	switch(t) {
	case 0: return "STDIN";
	case 1: return "STDOUT";
	case 2: return "STDERR";
	default: return "??";
	}
};

int main(int argc,char **argv) {
char c;

while ((c = getopt (argc, argv, "eohvf:O:t")) != -1)
	switch (c) {
	case 'h':
		printf("!! demux [-o stdout only] [-t show type] [-e stderr only] [-h help] [-v verbose'] [-f <file> (stdin)] [-O <file> (stdout)]\n");
		exit(0);
		break;
	case 'v':
		verbose=1;
		printf("!! Verbose ON\n");
		break; 
	case 'o':
		o=1;
		e=0;
		if(verbose) printf("!! Stdout only\n");
		break;
	case 'e':
		o=0;
		e=1;
		if(verbose) printf("!! Stderr only\n");
		break;
	case 't':
		showtype=1;
		if(verbose) printf("!! Show type ON\n");
		break;
	case 'f':
		fname=optarg;
		if(verbose) printf("!! Input file : %s\n",fname);
		break;
	case 'O':
		foutname=optarg;
		if(verbose) printf("!! Output file : %s\n",fname);
		break;
	default: 
		fprintf(stderr,"?? Unknown '%c' option...\n",optopt);
		exit(1);
	};

if(fname) {
	if(!(fin=fopen(fname,"rb"))) {
		fprintf(stderr,"!! Missing file %s...\n",fname);
		exit(2);
		};
	if(verbose) printf("!! %s opened\n",fname);
	}
else fin=stdin;

if(foutname) {
	if(!(fout=fopen(foutname,"wb"))) {
		fprintf(stderr,"!! Can't open file %s...\n",fname);
		exit(3);
		};
	if(verbose) printf("!! %s opened\n",foutname);
	}
else fout=stdout;

// Lecture header ==================
while(!feof(fin) && fread(header,sizeof(u_int8_t),8,fin)==8) {
	u_int32_t l=0;

	//for(int i=0;i<8;i++) printf("%d,",header[i]);printf("\n"); 
	//big endian
	//lecture unix : od -t d1 --endian big  tag | more
	u_int8_t t=header[0];
	// printf("lecture\n");
	if(t<0 || t>2 || header[1] || header[2] || header[3]) {
		fprintf(stderr,"?? Incorrect header (%u,%u,%u,%u)...\n",t,header[1],header[2],header[3]);
		exit(3);
		};
	for(int i=4;i<8;i++) {
		l<<=8;
		l+=header[i];
		};
	// printf("(%u,%u,%u,%u)\n",header[4],header[5],header[6],header[7]);
	if(showtype) fprintf(fout,"%5.5s : ",tprefix(t));

	if(verbose) printf("!! Type=%d (%s), l=%u\n",t,tprefix(t),l);	
	// Lecture/écriture charge ==================
	while(!feof(fin) && l) {
		int readb,writeb;
		int requestb;
		u_int8_t buf[BS];
		requestb=BS;
		if(requestb>l) requestb=l;
		// if(verbose) printf("!! Requested %u bytes\n",requestb);	
		readb=fread(buf,sizeof(u_int8_t),requestb,fin);
		writeb=fwrite(buf,sizeof(u_int8_t),readb,fout);
		l-=readb;
		// if(verbose) printf("!! Wrote %u bytes\n, %u to go\n",writeb,l);	
		};
	// =================================
	};
fclose(fin);
fclose(fout);
exit(0);
}


