#!/bin/bash
branch_name="$(b=$(git symbolic-ref -q HEAD); { [ -n "$b" ] && echo ${b##refs/heads/}; } || echo HEAD)"
echo -e "\033[32m Type your remote name \e[0m";
read repository
function repository_Assoc {
    local repository=$1
}
repository_Assoc "$repository"
echo -e "\033[36m git remote show $repository \e[0m";
git remote show "$repository" || { echo -e "\033[31m This remote does not exist \e[0m"; exit 1; }
function hierarchy_Assoc {
    arrayhierarchy=($1)
    count=0
    previous=null
    for branch in "${arrayhierarchy[@]}"
    do
        echo -e "\033[32m Processing branch $branch \e[0m";
        echo -e "\033[36m git checkout $branch \e[0m";
        git checkout $branch || { echo -e "\033[31m This branch does not exist \e[0m"; exit 1; }
        echo -e "\033[32m Updating branch $branch \e[0m";
        echo -e "\033[36m git pull $repository $branch \e[0m";
        git pull "$repository" $branch || { echo -e "\033[31m Error pulling \e[0m"; exit 1; }
        if [ $count -gt 0 ]
        then
            previous=${arrayhierarchy[$count - 1]}
            echo -e "\033[32m Fusion avec la branche $previous \e[0m";
            echo -e "\033[36m git pull $repository $previous \e[0m";
            git pull "$repository" $previous || { echo -e "\033[31m Error pulling \e[0m"; exit 1; }
            echo -e "\033[32m Push sur la branch $branch \e[0m";
            echo -e "\033[36m git push $repository $branch \e[0m";
            git push "$repository" $branch || { echo -e "\033[31m Error pushing \e[0m"; exit 1; }
        fi
        count=$(( $count + 1 ))
    done
}
echo -e "\033[32m Define your branch hierarchy ( space as separator ) \e[0m";
read hierarchy
hierarchy_Assoc "$hierarchy"
echo -e "\033[32m Go back to branch $branch_name \e[0m";
echo -e "\033[36m git checkout $branch_name \e[0m";
git checkout "$branch_name" || { echo -e "\033[31m This branch does not exist \e[0m"; exit 1; }
exit 1;
