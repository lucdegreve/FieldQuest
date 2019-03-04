rm(list=ls())

# install.packages("R.matlab")
# install.packages("caret")
# install.packages("randomForest")
# install.packages("rpart")
# install.packages("adabag")

library("R.matlab")
library("caret")
library("randomForest")
library("rpart")
library("adabag")

# Def des dimensions du premier doc
im = readMat('C:/Users/Lenovo/Desktop/FTP/Mini_projet_2_classification_hyperspectral/Indian_pines_corrected.mat')
size = dim(im$indian.pines.corrected)
Nx = size[1]
Ny = size[2]
Nb_bands = size[3]


# Definition en matrice 
X = matrix(rep(0, size[1]*size[2]*Nb_bands), nrow = size[1]*size[2], Nb_bands)
for (band in 1:Nb_bands){
    X[, band] = c(im$indian.pines.corrected[,,band])
}


#def des dimensions du doc des indices
im2  = readMat('C:/Users/Lenovo/Desktop/FTP/Mini_projet_2_classification_hyperspectral/Indian_pines_gt.mat')
size = dim(im2$indian.pines.gt)
Nx2 = size[1]
Ny2 = size[2]


# Definition de la matrice Y de dimensions cohérentes avec la matrice X
Y = matrix(rep(0, size[1]*size[2]), nrow = size[1]*size[2], 1)
Y[, 1] = c(im2$indian.pines.gt[,])
Y = as.factor(Y)


# Definition des levels de Y pour avoir des indices de 1 à n
class = levels(Y)
len = length(class)
i = 0
base_app = data.frame(matrix(NA, nrow = 1, ncol = 200))
base_test = data.frame(matrix(NA, nrow = 1, ncol = 200))


# Boucle while permettant de créer une data frame base d'apprentissage pour chaque classe
while (i<=len-1){
  nam <- paste("df", i, sep="")
  assign(nam, data.frame(subset(X, Y == i)))
  nam2 <- paste("app_", i, sep="")
  
  
# Boucle if permettant de mettre la moitié des données dans la base d'apprentissage ou 100 si la classe contient plus de 200 lignes
  if (((dim(get(nam))[1])) < 200){
    tirage=sample(nrow(get(nam)), (dim(get(nam))[1])/2)
    assign(nam2, get(nam)[tirage, ])
  }
  else {
    tirage=sample(nrow(get(nam)), 100)
    assign(nam2, get(nam)[tirage, ])
  }
  nam3 <- paste("test_", i, sep="")
  assign(nam3, get(nam)[-tirage, ])
  
  
# Concaténation de toutes les bases pour former la base finale d'apprentissage et de test 
  base_app = rbind(base_app, get(nam2))
  base_test = rbind(base_test,  get(nam3))

  
  i = i+1
}
base_app=base_app[-1, ]
base_test=base_test[-1, ]
set.seed(71)
rf <- randomForest(X1 ~ ., data=base_app, ntree = 200, na.action = na.roughfix)



