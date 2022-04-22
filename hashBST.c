#include<stdio.h>
#include <string.h>
#include<stdlib.h>

#define MAX_L 100
#define MAX 100000
#define M 100

typedef struct Node
{
    char name[256];
    char email[256];
    struct Node* rightChild;
    struct Node* leftChild;
}Node;

Node* root[M];

int hash(char* s)
{
    int rs=0;
    int n=strlen(s);
    for (int i=0;i<n;i++)
    {
        rs=(rs*255+s[i])%M;
    }
    return rs;
}

Node* makeNode(char* name,char* email)
{
    Node*p=malloc(sizeof(Node));
    strcpy(p->name,name);
    strcpy(p->email,email);
    p->rightChild=NULL;
    p->leftChild=NULL;
    return p;
}

Node* insert(Node* r,char* name,char* email)
{
    if (r==NULL) return makeNode(name,email);
    int c=strcmp(r->name,name);
    if (c==0)
    {
        printf("Students %s exists\n",name);
        return r;
    }
    else if (c>0)
    {
        r->leftChild=insert(r->leftChild,name,email);
        return r;
    }
    else 
    {
        r->rightChild=insert(r->rightChild,name,email);
        return r;
    }
}

void load(char* filename)
{
    FILE* f = fopen(filename,"r");
    if (f==NULL) printf("Load data -> file not found\n");
    for (int i=0;i<M;i++)
    {
        root[i]=NULL;
    }
    while (!feof(f))
    {
        char name[256],email[256];
        fscanf(f,"%s%s",name,email);
        int idx=hash(name);
        root[idx]=insert(root[idx],name,email);
    }
    fclose(f);   
}

void processLoad()
{
    char filename[100];
    printf("Nhap ten file: ");
    scanf("%s",filename);
    load(filename);
}

void inOrder(Node* r)
{
    if (r==NULL) return;
    inOrder(r->leftChild);
    printf("%s, %s\n",r->name,r->email);
    inOrder(r->rightChild);
}

void printList()
{
    for (int i=0;i<M;i++)
    {
        inOrder(root[i]);
    }
   
}

Node* find(Node* r,char* name)
{
    if (r==NULL) return NULL;
    int c = strcmp(r->name,name);
    if (c==0) return r;
    if (c<0) return find(r->rightChild,name);
    return find(r->leftChild,name);
}

Node* findMin(Node* r)
{
    if (r==NULL) return NULL;
    Node* lmin=findMin(r->leftChild);
    if (lmin!=NULL) return lmin;
    return r;
}

void processFind()
{
    char name[100];
    printf("Nhap ten: ");
    scanf("%s",name);
    int idx = hash(name);
    Node* tmp=find(root[idx],name);
    if (tmp==NULL) printf("Not found %s\n",name);
    else printf("Found %s\n",name);

    // for (int i=0;i<M;i++)
    // {
    //     tmp=find(root[i],name);
    // }
    // if (tmp==NULL) printf("Not found %s\n",name);
    // else printf("Found %s\n",name);
}

Node* removeStudent(Node* r,char* name)
{
    if (r==NULL) return NULL;
    int c=strcmp(r->name,name);
    if (c>0)
    {
        r->leftChild=removeStudent(r->leftChild,name);
    }
    else if (c<0)
    {
        r->rightChild=removeStudent(r->rightChild,name);
    }
    else 
    {
        if (r->rightChild!=NULL&&r->rightChild!=NULL)
        {
            Node* tmp=findMin(r->rightChild);
            strcpy(r->name,tmp->name);
            strcmp(r->email,tmp->email);
            r->rightChild=removeStudent(r->rightChild,tmp->name);
        }
        else
        {
            Node* tmp=r;
            if (r->leftChild==NULL) r=r->rightChild;
            else r=r->leftChild;
            free(tmp);
        }
    }
    return r;
}

void processRemove()
{
    char name[100];
    printf("Nhap ten: ");
    scanf("%s",name);
    int idx=hash(name);
    root[idx]=removeStudent(root[idx],name);
}

void freeTree(Node* r)
{
    if (r==NULL) return;
    freeTree(r->leftChild);
    freeTree(r->rightChild);
    free(r);
}

void processInsert()
{
    char name[100],email[100];
    printf("Nhap ten, email: ");
    scanf("%s%s",name,email);
    int idx=hash(name);
    root[idx]=insert(root[idx],name,email);
}

void inOrderF(Node* r,FILE* f)
{
    if (r==NULL) return;
    inOrderF(r->leftChild,f);
    fprintf(f,"%s %s\n",r->name,r->email);
    inOrderF(r->rightChild,f);
}

void processStore()
{
    char filename[100];
    printf("Nhap ten file: ");
    scanf("%s",filename);
    FILE* f=fopen(filename,"w");
    for (int i=0;i<M;i++)
    {
        inOrderF(root[i],f);
    }
    fclose(f);
}

int main()
{
    char cmd[100];
    while (1)
    {
        printf("Enter command: ");
        scanf("%s",cmd);
        if (strcmp(cmd,"Quit")==0) break;
        else if (strcmp(cmd,"Load")==0) processLoad();
        else if (strcmp(cmd,"Print")==0) printList();
        else if (strcmp(cmd,"Insert")==0) processInsert();
        else if (strcmp(cmd,"Remove")==0) processRemove();
        else if (strcmp(cmd,"Find")==0) processFind();
        else if (strcmp(cmd,"Store")==0) processStore();
    }
    
}