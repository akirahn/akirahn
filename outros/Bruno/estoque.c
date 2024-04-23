#include <stdio.h>
#include <stdlib.h>

typedef struct No {
	int codigo, quantidade;
	float valor;
	char descricao;
  struct No *proximo;
} No;

typedef struct {
  No *inicio, *fim;
  int tam;
} Lista;

// inser��o no in�cio da lista
void inserirInicio(Lista *lista, int codigo, char descricao, int quantidade, float valor) {
  No *novo = (No*)malloc(sizeof(No)); // cria um novo n�
  novo->codigo = codigo;
  novo->descricao = descricao;
  novo->quantidade = quantidade;
  novo->valor = valor;

  if(lista->inicio == NULL) { // a lista est� vazia
    novo->proximo = NULL;
    lista->inicio = novo;
    lista->fim = novo;
  } else { // a lista n�o est� vazia
    novo->proximo = lista->inicio;
    lista->inicio = novo;
  }
  lista->tam++;
}

// Consultar codigo na lista
void consultar(Lista *lista, int codigo) {
  No *inicio = lista->inicio;
  while(inicio != NULL) {
		if (inicio->codigo == codigo) {
			printf("ProdutO: \n");
			printf("C�digo: %d\n", inicio->codigo);
			printf("Descri��o: %d\n", inicio->descricao);
			printf("Quantidade: %d\n", inicio->quantidade);
			printf("Valor: %f\n", inicio->valor);
		}
    inicio = inicio->proximo;
  }
  printf("\n\n");
}

// imprimir a lista
void imprimir(Lista *lista) {
  No *inicio = lista->inicio;
  printf("Tamanho da lista: %d\n", lista->tam);
  while(inicio != NULL) {
    printf("C�digo: %d\n", inicio->codigo);
    printf("Descri��o: %d\n", inicio->descricao);
    printf("Quantidade: %d\n", inicio->quantidade);
    printf("Valor: %f\n", inicio->valor);
    inicio = inicio->proximo;
  }
  printf("\n\n");
}

// remover um elemento da lista
void remover(Lista *lista, int codigo) {
  No *inicio = lista->inicio; // ponteiro para o in�cio da lista
  No * noARemover = NULL; // ponteiro para o n� a ser removido

  if(inicio != NULL && lista->inicio->codigo == codigo) { // remover 1� elemento
    noARemover = lista->inicio;
    lista->inicio = noARemover->proximo;
    if(lista->inicio == NULL)
      lista->fim = NULL;
  } else { // remo��o no meio ou no final
    while(inicio != NULL && inicio->proximo != NULL && inicio->proximo->codigo != codigo) {
      inicio = inicio->proximo;
    }
    if(inicio != NULL && inicio->proximo != NULL) {
      noARemover = inicio->proximo;
      inicio->proximo = noARemover->proximo;
      if(inicio->proximo == NULL) // se o �ltimo elemento for removido
        lista->fim = inicio;
    }
  }
  if(noARemover) {
    free(noARemover); // libera a mem�ria do n�
    lista->tam--; // decrementa o tamanho da lista
  }
}

int main() {
  Lista lista;
  int opcao, produto, codigo, quantidade;
	float valor;
	char descricao; 

  // inicializa��o das listas
  lista.inicio = NULL;
  lista.fim = NULL;
  lista.tam = 0;

  do { // menu de op��es
    printf("1 - Cadastrar\n2 - Consulta\n3 - Remover Produto\n4 - Relat�rio\n5 - Sair\n");
    scanf("%d", &opcao);

    switch(opcao) {
    case 1:
      printf("Digite um produto a ser inserido: ");
      scanf("%s", &descricao);
			printf("Digite um codigo a ser inserido: ");
      scanf("%d", &codigo);
      printf("Digite um quantidade a ser inserido: ");
      scanf("%d", &quantidade);
      printf("Digite um valor a ser inserido: ");
      scanf("%f", &valor);
      inserirInicio(&lista, codigo, descricao, valor, quantidade);
      break;
    case 2:
      printf("\nConsulta:\n");
      printf("Informe o c�digo: ");
			scanf("%d", &codigo);
      consultar(&lista, codigo);
      break;
    case 3:
      printf("Digite um produto a ser removido: ");
      scanf("%d", &produto);
      remover(&lista, produto);
      break;
    case 4:
      printf("\nRelat�rio:\n");
      imprimir(&lista);
      break;
    case 5:
      printf("Finalizando...\n");
      break;
    default:
      printf("Opcao invalida!\n");
    }
  } while(opcao != 5);

  return 0;
}
